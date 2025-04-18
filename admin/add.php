<?php
require 'auth.php';

$dataFile = '../data/products.json';
$targetDir = '../images/';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $link = $_POST['link'];
    $imageName = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        $targetPath = $targetDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $error = 'Gagal upload gambar!';
        }
    } else {
        $error = 'Gambar wajib diupload!';
    }

    if (!$error) {
        $newProduct = [
            'id' => $id,
            'nama' => $nama,
            'image' => 'images/' . $imageName,
            'link' => $link
        ];

        $products = [];
        if (file_exists($dataFile)) {
            $json = file_get_contents($dataFile);
            $products = json_decode($json, true);
        }

        $products[] = $newProduct;
        file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT));
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Tambah Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="id" placeholder="ID Produk" required>
        <input type="text" name="nama" placeholder="Nama Produk" required>
        <input type="text" name="link" placeholder="Link Produk" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Simpan</button>
        <a href="index.php" style="display:block; margin-top:10px; text-align:center;">← Kembali</a>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
