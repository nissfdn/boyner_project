<?php
$host = "localhost";   // 127.0.0.1 yerine localhost yazmak daha yaygın
$user = "root";        // phpMyAdmin'de görünen kullanıcı
$pass = "";             // XAMPP default, şifre yok
$db   = "boyner_project"; // URL'de gördüğümüz DB adı

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Baglanti hatasi: " . mysqli_connect_error());
}
?>
