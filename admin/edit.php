<?php
require 'auth.php';

$dataFile = '../data/products.json';
$targetDir = '../images/';
$error = '';

if (!isset($_GET['index'])) {
    header('Location: index.php');
    exit;
}

$index = $_GET['index'];

$products = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $products = json_decode($json, true);
}

if (!isset($products[$index])) {
    header('Location: index.php');
    exit;
}

$product = $products[$index];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $link = $_POST['link'];

    // update info dasar
    $products[$index]['id'] = $id;
    $products[$index]['nama'] = $nama;
    $products[$index]['link'] = $link;

    // jika upload gambar baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        $targetPath = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            // hapus gambar lama
            if (file_exists('../' . $product['image'])) {
                unlink('../' . $product['image']);
            }

            $products[$index]['image'] = 'images/' . $imageName;
        } else {
            $error = 'Gagal upload gambar!';
        }
    }

    if (!$error) {
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
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 480px; margin: auto; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        .error { color: red; margin-top: 10px; }
        img { width: 100%; max-height: 200px; object-fit: cover; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Edit Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="id">ID Produk :</label>
        <input type="text" name="id" value="<?= htmlspecialchars($product['id']) ?>" required>

        <label for="nama">Nama Produk :</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($product['nama']) ?>" required>

        <label for="link">Link Produk :</label>
        <input type="text" name="link" value="<?= htmlspecialchars($product['link']) ?>" required>

        <p>Gambar Saat Ini:</p>
        <img src="../<?= htmlspecialchars($product['image']) ?>" alt="Gambar Produk">
        <input type="file" name="image" accept="image/*">

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php" style="display:block; margin-top:10px; text-align:center;">← Kembali</a>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
