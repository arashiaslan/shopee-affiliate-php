<?php
require 'auth.php';

$dataFile = '../data/products.json';
$targetDir = '../images/';

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

// hapus file gambar
if (file_exists('../' . $products[$index]['image'])) {
    unlink('../' . $products[$index]['image']);
}

// hapus data dari array
array_splice($products, $index, 1);

// simpan kembali
file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT));

header('Location: index.php');
exit;
?>
