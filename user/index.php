<?php
include 'proses.php';
session_start();
$produk = tampilkanProduk($conn);

if($_SERVER['REQUEST_METHOD']=="POST"){
    $filter = $_POST['filter'];
    $dicari = $_POST['dicari'];
    $produk = pencarian_PRODUK($conn, $filter, $dicari);
}
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
            <a href="index.php">
            <div class="logo">
                <h1>WEBSITE PENJUALAN JAM TANGAN</h1>
            </div>
            </a>
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
            <form action="" method="POST">
            <div class="mb-3">
                <select class="form-select form-select-lg" name="filter" id="filter">
                    <option selected value="nama">Filter</option>
                    <option value="nama">Nama Produk</option>
                    <option value="merk">Brand</option>
                </select>
            </div>
            <input type="text" name="dicari" placeholder="Pencarian ...">
            <button type="submit" name="Cari" >Cari</button>
            </form>
        </div>
    </section>

    <main>
        <div class="product-grid">
            <?php
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