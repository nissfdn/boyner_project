<?php
include "Config.php";

$sql = "SELECT * FROM products LIMIT 25";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<a href="logout.php">Çıkış Yap</a>

<h2>Çocuk Ürünleri</h2>

<hr>

<div class="products">

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <div class="product-card">
        <img src="images/<?= $row['image'] ?>" width="150">
        <h4><?= $row['brand'] ?></h4>
        <p><?= $row['name'] ?></p>
        <strong><?= $row['price'] ?> ₺</strong><br><br>

        <a href="Shopping.php?id=<?= $row['id'] ?>">Detay</a>
    </div>
<?php
    }
} else {
    echo "<p>Ürün bulunamadı.</p>";
}
?>

</div>

<br>
<a href="Index.php">← Geri Dön</a>

</body>
</html>
