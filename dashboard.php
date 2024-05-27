<?php
include('includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>

<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Hoş Geldiniz!</h1>
    <p>Bu uygulama, yazılım geliştirme ekibinizin iş akışını yönetmenize yardımcı olacaktır.</p>
    <div class="row">
        <div class="col-md-6">
            <h2>Proje Yönetimi</h2>
            <a href="/web_project2/projects/projects.php" class="btn btn-primary btn-block">Projeleri Yönet</a>
        </div>
        <div class="col-md-6">
            <h2>Görev Yönetimi</h2>
            <a href="/web_project2/tasks/tasks.php" class="btn btn-primary btn-block">Görevleri Yönet</a>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>