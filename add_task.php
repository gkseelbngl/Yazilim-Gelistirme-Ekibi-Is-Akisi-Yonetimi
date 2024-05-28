<?php
include('db.php');
session_start();

date_default_timezone_set('Europe/Istanbul');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];
    $created_at = date("Y-m-d H:i:s");

    error_log("Project ID: $project_id, Title: $title, Description: $description, Assigned To: $assigned_to, Status: $status");

    $stmt = $conn->prepare("INSERT INTO tasks (project_id, title, description, assigned_to, status, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("isssis", $project_id, $title, $description, $assigned_to, $status, $created_at);

    if ($stmt->execute()) {
        header("Location: tasks.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$projects_sql = "SELECT * FROM projects";
$projects_result = $conn->query($projects_sql);

$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);
?>

<?php include('header.php'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Yeni Görev Ekle</h2>
    <form id="add-task-form" method="post" action="">
        <div class="form-group">
            <label for="project_id">Proje:</label>
            <select class="form-control" name="project_id" id="project_id">
                <?php while ($project = $projects_result->fetch_assoc()) { ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo $project['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Başlık:</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama:</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="assigned_to">Atanacak Kişi:</label>
            <select class="form-control" name="assigned_to" id="assigned_to">
                <?php while ($user = $users_result->fetch_assoc()) { ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Durum:</label>
            <select class="form-control" name="status" id="status">
                <option value="To Do">Yapılacak</option>
                <option value="In Progress">Devam Ediyor</option>
                <option value="Done">Tamamlandı</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Görevi Ekle</button>
        <a href="tasks.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
<?php include('footer.php'); ?>