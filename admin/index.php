<?php
require 'auth.php';

$dataFile = '../data/products.json';
$products = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $products = json_decode($json, true);
}

$search = '';
if (isset($_GET['search'])) {
    $search = strtolower(trim($_GET['search']));
    $products = array_filter($products, function ($p) use ($search) {
        return strpos(strtolower($p['nama']), $search) !== false ||
               strpos(strtolower($p['id']), $search) !== false;
    });
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        button, .btn {
            max-width: 90%;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <a href="add.php" class="btn">+ Tambah Produk</a>
        <a href="logout.php" class="btn delete">Logout</a>
    </div>

    <form method="GET">
        <input 
            type="text" 
            name="search" 
            placeholder="Cari ID atau Nama produk..." 
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
            style="padding: 10px; width: 95%; margin-bottom: 15px;"
        >
    </form>

    <h2>Daftar Produk</h2>

    <?php if (empty($products)): ?>
        <p>Belum ada produk.</p>
    <?php else: ?>
        <?php foreach ($products as $index => $product): ?>
            <div class="product">
                <img src="../<?= htmlspecialchars($product['image']) ?>" alt="Produk">
                <p><?= htmlspecialchars($product['id']) . ' - ' . htmlspecialchars($product['nama']) ?></p>
                <p><a href="<?= htmlspecialchars($product['link']) ?>" target="_blank">Lihat Produk</a></p>
                <div class="actions">
                    <a href="edit.php?index=<?= $index ?>" class="btn">Edit</a>
                    <a href="delete.php?index=<?= $index ?>" class="btn delete" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
