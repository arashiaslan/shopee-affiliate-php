<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="icon.png" type="image/x-icon">
  <title>Barang Unik</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <div class="search-area">
            <div class="search-box">
            <div id="back-button" style="display:none; margin: 10px;">
            <button onclick="resetSearch()" style="background:none;border:none;">
                <img src="arrow-back.svg" alt="Back" style="width:24px; vertical-align: middle;">
            </button>
            </div>
            <input type="text" id="search" placeholder="Search for Links" oninput="searchProduct()">
            </div>
            <div class="highlight-box">
            <img src="profile.jpg" alt="Highlight">
            <div class="highlight-text">
                <h3>Barang Unik!</h3>
                <p>Koleksi Barang Unik dan Murah!</p>
            </div>
            </div>
        </div>
        <div class="product-grid">
            <?php
            $dataFile = 'data/products.json';
            if (file_exists($dataFile)) {
            $json = file_get_contents($dataFile);
            $products = json_decode($json, true);

            foreach ($products as $product) {
                echo '<div class="product">';
                echo '<a href="' . htmlspecialchars($product['link']) . '" target="_blank">';
                echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['nama']) . '">';
                echo '<div class="product-name">' . htmlspecialchars($product['id']) . ' - ' . htmlspecialchars($product['nama']) .'</div>';
                echo '</a>';
                echo '</div>';
            }
            } else {
            echo '<p style="padding: 15px;">Belum ada produk.</p>';
            }
            ?>
        </div>
        <p id="not-found" style="text-align:center; padding:20px; display:none;">Produk Tidak Ditemukan.</p>
    </div>
    <script src="script.js"></script>
</body>
</html>