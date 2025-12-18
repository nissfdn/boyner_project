<?php //html css gelince php onlara baglanicak genel kullanim hazir
session_start();
include "config.php";
//echo "index calisiyor<br>";

if (isset($_SESSION['username'])) {
    header("Location: products.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header("Location: products.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

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
