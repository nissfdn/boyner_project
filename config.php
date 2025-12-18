<?php //bitti
$host = "localhost";
$user = "root";
$pass = "";
$db   = "boyner_project";

$mysqli = new mysqli($host, $user, $pass, $db); //mysql ile php birlestiriyor veritabanindan ne istedigini soyluyor

if ($mysqli->connect_error) {
    die("Connection Error: " . $mysqli->connect_error); //baglanti hatasi olursa programi durdur hata mesajini ver
}
?>
