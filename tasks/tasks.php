<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT tasks.*, projects.name AS project_name, users.username 
        FROM tasks 
        LEFT JOIN projects ON tasks.project_id = projects.id 
        LEFT JOIN users ON tasks.assigned_to = users.id";
$result = $conn->query($sql);

if (!$result) {
    die("Sorgu başarısız: " . $conn->error);
}

// Durumları Türkçeye çevirme fonksiyonu
function translate_status($status)
{
    switch ($status) {
        case 'To Do':
            return 'Yapılacak';
        case 'In Progress':
            return 'Devam Ediyor';
        case 'Done':
            return 'Tamamlandı';
        default:
            return $status;
    }
}

?>

<?php include('../includes/header.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Görevler</h1>
    <a href="add_task.php" class="btn btn-primary mb-4">Yeni Görev Ekle</a>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>Proje</th>
                <th>Atanan Kişi</th>
                <th>Durum</th>
                <th>Oluşturulma Tarihi</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($task = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                    <td><?php echo htmlspecialchars($task['username']); ?></td>
                    <td><?php echo htmlspecialchars(translate_status($task['status'])); ?></td>
                    <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                    <td>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-secondary btn-sm">Düzenle</a>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm delete-task">Sil</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>