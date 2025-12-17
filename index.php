<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boyner Login</title>
</head>
<body>

<div class="navbar">
    <div>
        <p>logo</p>
    </div>
</div>

<?php
include "config/db.php";
echo "index calisiyor<br>";

// Eğer kullanıcı zaten giriş yaptıysa products.php'ye gönder
if (isset($_SESSION['user'])) {
    header("Location: products.php");
    exit();
}

$error = "";

// Login butonuna basıldıysa
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Veritabanında kullanıcı var mı kontrol et
    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Login başarılı
        $_SESSION['user'] = $username;
        header("Location: products.php");
        exit();
    } else {
        // Login başarısız
        $error = "Invalid username or password!";
    }
}
?>

<h2>Welcome to Boyner Çocuk</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<p style="color:red;">
    <?php echo $error; ?>
</p>

</body>
</html>
