<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        header("Location: projects.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php include('../includes/header.php'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Yeni Proje Ekle</h2>
    <form id="add-project-form" method="post" action="">
        <div class="form-group">
            <label for="name">Proje Adı:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="description">Açıklama:</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Proje Ekle</button>
        <a href="projects.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
<?php include('../includes/footer.php'); ?>