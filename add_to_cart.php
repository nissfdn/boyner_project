<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Güvenli veri alma (Formdan gelen renk ve bedeni de ekledik)
$id      = $_POST['product_id']    ?? null;
$brand   = $_POST['product_brand'] ?? 'BOYNER';
$name    = $_POST['product_name']  ?? '';
$price   = isset($_POST['product_price']) 
            ? floatval(str_replace(",", ".", $_POST['product_price'])) 
            : 0;
$image   = $_POST['product_image'] ?? 'no-image.webp';

// --- YENİ EKLENEN KISIMLAR ---
$color   = $_POST['product_color'] ?? 'Varsayılan'; // Formdaki renk name'i neyse onu yazın
$size    = $_POST['product_size']  ?? 'Standart';  // Formdaki beden name'i neyse onu yazın

// Benzersiz anahtar oluşturuyoruz (ID + Renk + Beden)
// Bu sayede "123_Mavi_3Yaş" ile "123_Pembe_3Yaş" ayrı satırlar olur.
$cart_key = $id . "_" . $color . "_" . $size;
// ----------------------------

if (!$id) {
    header("Location: products.php");
    exit;
}

// Sepette tam olarak bu varyasyon (anahtar) varsa miktar artır
if (isset($_SESSION['cart'][$cart_key])) {
    $_SESSION['cart'][$cart_key]['qty']++;
} else {
    // Yoksa yeni bir satır olarak ekle
    $_SESSION['cart'][$cart_key] = [
        "id"    => $id,
        "brand" => $brand,
        "name"  => $name,
        "price" => $price,
        "image" => $image,
        "color" => $color, // Rengi kaydet
        "size"  => $size,  // Bedeni kaydet
        "qty"   => 1
    ];
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit;