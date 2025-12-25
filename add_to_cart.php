<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Güvenli veri alma
$id     = $_POST['product_id']    ?? null;
$brand  = $_POST['product_brand'] ?? 'BOYNER';
$name   = $_POST['product_name']  ?? '';
$price  = isset($_POST['product_price']) 
            ? floatval(str_replace(",", ".", $_POST['product_price'])) 
            : 0;
$image  = $_POST['product_image'] ?? 'no-image.webp';

// Ürün ID yoksa çık
if (!$id) {
    header("Location: products.php");
    exit;
}

// Sepette varsa artır
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty']++;
} else {
    $_SESSION['cart'][$id] = [
        "brand" => $brand,
        "name"  => $name,
        "price" => $price,
        "image" => $image,
        "qty"   => 1
    ];
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit;
