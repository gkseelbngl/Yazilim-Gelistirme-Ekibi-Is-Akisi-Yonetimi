<?php
include('../includes/db.php');
session_start();

date_default_timezone_set('Europe/Istanbul');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $status = isset($_POST['status']) ? $_POST['status'] : 'To Do'; // Varsayılan değer 'To Do'
    $current_timestamp = date("Y-m-d H:i:s");

    // Durumları Türkçeye çevirme
    $status_turkish = '';
    if ($status == 'To Do') {
        $status_turkish = 'Yapılacak';
    } elseif ($status == 'In Progress') {
        $status_turkish = 'Devam Ediyor';
    } elseif ($status == 'Done') {
        $status_turkish = 'Tamamlandı';
    }

    // Seçili görevin bilgilerini güncelle
    $stmt = $conn->prepare("UPDATE tasks SET project_id = ?, title = ?, description = ?, assigned_to = ?, status = ?, created_at = ? WHERE id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("isssisi", $project_id, $title, $description, $assigned_to, $status, $current_timestamp, $task_id);

    if ($stmt->execute()) {
        // Tüm görevlerin durumunu güncelle
        $update_all_tasks_status = $conn->prepare("UPDATE tasks SET status = ? WHERE project_id = ?");
        if ($update_all_tasks_status === false) {
            die("Prepare failed: " . $conn->error);
        }
        $update_all_tasks_status->bind_param("si", $status, $project_id);

        if ($update_all_tasks_status->execute()) {
            header("Location: tasks.php");
            exit();
        } else {
            echo "Error: " . $update_all_tasks_status->error;
        }

        $update_all_tasks_status->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$task_id = $_GET['id'];
$task_sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($task_sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$task_result = $stmt->get_result();
$task = $task_result->fetch_assoc();

$projects_sql = "SELECT * FROM projects";
$projects_result = $conn->query($projects_sql);

$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);
?>

<?php include('../includes/header.php'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Görevi Düzenle</h2>
    <form id="edit-task-form" method="post" action="">
        <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
        <div class="form-group">
            <label for="project_id">Proje:</label>
            <select class="form-control" name="project_id" id="project_id">
                <?php while ($project = $projects_result->fetch_assoc()) { ?>
                    <option value="<?php echo $project['id']; ?>" <?php if ($project['id'] == $task['project_id']) echo 'selected'; ?>><?php echo $project['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Başlık:</label>
            <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama:</label>
            <textarea class="form-control" name="description" id="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="assigned_to">Atanacak Kişi:</label>
            <select class="form-control" name="assigned_to" id="assigned_to">
                <?php while ($user = $users_result->fetch_assoc()) { ?>
                    <option value="<?php echo $user['id']; ?>" <?php if ($user['id'] == $task['assigned_to']) echo 'selected'; ?>><?php echo $user['username']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Durum:</label>
            <select class="form-control" name="status" id="status">
                <option value="To Do" <?php if ($task['status'] == 'To Do') echo 'selected'; ?>>Yapılacak</option>
                <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>Devam Ediyor</option>
                <option value="Done" <?php if ($task['status'] == 'Done') echo 'selected'; ?>>Tamamlandı</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Görevi Güncelle</button>
        <a href="tasks.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
<?php include('../includes/footer.php'); ?>