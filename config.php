<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "boyner_project";

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die("Bağlantı hatası: " . $mysqli->connect_error);
}
?>
