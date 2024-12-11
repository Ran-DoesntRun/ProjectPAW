<?php
include 'proses.php';
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Store</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>WEBSITE PENJUALAN JAM TANGAN</h1>
            </div>
            <div class="header-buttons">
                <a href="RiwayatTransaksi.php" class="cart-icon">🛒</a>
                <?php
                    if (!isset($_SESSION['user'])) {
                ?>
                        <a href="login.php"><button>Masuk</button></a>
                        <a href="signup.php"><button>Daftar</button></a>
                    
                    <?php } else { ?>
                        <a href="logout.php"><button>Keluar</button></a>
                    <?php }?>
                        
                
            </div>
        </div>
    </header>

    <section class="banner">
        <div class="banner-content">
            <h2>PENJUALAN JAM ONLINE</h2>
            <p>DISCOUNT HINGGA 75% SAMPAI 20 NOVEMBER 2024</p>
        </div>
    </section>

    <main>
        <div class="product-grid">
            <?php
            $produk = tampilkanProduk($conn);
            if (count($produk) > 0): 
            foreach ($produk as $item): ?>
            <div class="product">
                <img src="<?php echo $item['foto']; ?>" alt="<?php echo $item['nama']; ?>">
                <p>
                    <?php echo $item['nama']; ?>
                </p>
                <p class="price">
                    <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                </p>
                <a href="buy.php?product=<?php echo $item['idProduk']; ?>" class="buy-button">Beli Sekarang</a>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="product">
                <p>Tidak ada data produk.</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
</body>
</hr>