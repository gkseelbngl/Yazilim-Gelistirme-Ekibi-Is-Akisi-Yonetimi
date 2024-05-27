<?php
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        } else {
            $error = "Geçersiz kullanıcı adı veya şifre!";
        }
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre!";
    }
}
?>

<?php include('includes/header.php'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Giriş Yap</h2>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Giriş Yap</button>
        <a href="register.php" class="btn btn-secondary">Kayıt Ol</a>
    </form>
</div>
<?php include('includes/footer.php'); ?>