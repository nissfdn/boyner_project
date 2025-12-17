<?php
include "Config.php";

/* GET VALUES */
$search   = $_GET['search']   ?? '';
$category = $_GET['category'] ?? '';
$gender   = $_GET['gender']   ?? '';

$sql = "SELECT * FROM products WHERE 1=1";

/* SEARCH */
if ($search != '') {
    $sql .= " AND (name LIKE '%$search%' OR brand LIKE '%$search%')";
}

/* FILTER 1 */
if ($category != '') {
    $sql .= " AND category = '$category'";
}

/* FILTER 2 */
if ($gender != '') {
    $sql .= " AND gender = '$gender'";
}

/* LIMIT */
$sql .= " LIMIT 25";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Çocuk Ürünleri</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Marka veya ürün ara"
           value="<?= htmlspecialchars($search) ?>">

    <select name="category">
        <option value="">Kategori</option>
        <option value="Tshirt">Tshirt</option>
        <option value="Ayakkabı">Ayakkabı</option>
        <option value="Eşofman">Eşofman</option>
    </select>

    <select name="gender">
        <option value="">Cinsiyet</option>
        <option value="Kız">Kız</option>
        <option value="Erkek">Erkek</option>
    </select>

    <button type="submit">Filtrele</button>
</form>

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

        <!-- PARAMETER PASSING -->
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

