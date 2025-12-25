<?php
session_start();

header('Content-Type: application/json');

// JavaScript'ten gelen veriyi al
$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'] ?? null;
$action = $input['action'] ?? null;

if ($id && $action && isset($_SESSION['cart'][$id])) {
    
    // Adet artırma / azaltma mantığı
    if ($action === 'increase') {
        $_SESSION['cart'][$id]['qty']++;
    } elseif ($action === 'decrease') {
        if ($_SESSION['cart'][$id]['qty'] > 1) {
            $_SESSION['cart'][$id]['qty']--;
        }
    }

    // Yeni değerleri hesapla
    $yeniAdet = $_SESSION['cart'][$id]['qty'];
    $urunFiyati = $_SESSION['cart'][$id]['price'];
    $urunToplam = $yeniAdet * $urunFiyati;

    // Genel Toplamı Hesapla
    $genelToplam = 0;
    foreach ($_SESSION['cart'] as $item) {
        $genelToplam += ($item['price'] * $item['qty']);
    }

    // JavaScript'e cevap ver (JSON formatında)
    echo json_encode([
        'status' => 'success',
        'newQty' => $yeniAdet,
        'newItemTotal' => number_format($urunToplam, 2, ',', '.') . ' TL',
        'newGrandTotal' => number_format($genelToplam, 2, ',', '.') . ' TL'
    ]);
} else {
    echo json_encode(['status' => 'error']);
}
?>