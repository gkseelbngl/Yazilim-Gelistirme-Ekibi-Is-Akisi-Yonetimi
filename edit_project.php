<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE projects SET name = ?, description = ? WHERE id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssi", $name, $description, $id);

    if ($stmt->execute()) {
        header("Location: projects.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$id = $_GET['id'];
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die("Proje bulunamadı!");
}
?>

<?php include('header.php'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Projeyi Düzenle</h2>
    <form id="edit-project-form" method="post" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($project['id']); ?>">
        <div class="form-group">
            <label for="name">Proje Adı:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama:</label>
            <textarea class="form-control" name="description" id="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="projects.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
<?php include('footer.php'); ?>