<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT * FROM projects";
$result = $conn->query($sql);

if (!$result) {
    die("Sorgu başarısız: " . $conn->error);
}
?>

<?php include('../includes/header.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Projeler</h1>
    <a href="add_project.php" class="btn btn-primary mb-4">Yeni Proje Ekle</a>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Proje Adı</th>
                <th>Açıklama</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($project = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($project['name']); ?></td>
                    <td><?php echo htmlspecialchars($project['description']); ?></td>
                    <td>
                        <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn btn-secondary btn-sm">Düzenle</a>
                        <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="btn btn-danger btn-sm delete-project">Sil</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>