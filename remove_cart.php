<?php
session_start();

// URL'den silinecek ürünün ID'sini al
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Eğer ID varsa ve sepette bu ürün mevcutsa
if ($id && isset($_SESSION['cart'][$id])) {
    // Ürünü diziden (sepetten) kaldır
    unset($_SESSION['cart'][$id]);
}

// İşlem bitince sepet sayfasına (summary.php) geri dön
header("Location: summary.php");
exit;
?>