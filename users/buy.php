<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Watch</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <?php
    include "proses.php";

    session_start();
      if (!isset($_SESSION['user'])) {
        header("location: login.php");
      }

    $email = $_SESSION['user'];
    echo $_SESSION['user'];
    
    $id  = $_GET['product'];
    $dataProduk = tampilByIdProduk($conn, $id);
    $dataPelanggan = tampilPelanggan($conn, $email);

    
    ?>

    <header>
        <div class="header-container">
            <div class="logo">
                <h1>WEBSITE PENJUALAN JAM TANGAN</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="purchase-container">
            <h2>Detail Pembelian</h2>
            <div class="product-details">
                <img id="product-image" src="<?php echo $dataProduk['foto'];?>" alt="<?php echo $dataProduk["nama"] ?>">
                <p id="product-name"> <?php echo $dataProduk["nama"] ?> </p>
                <p id="product-color"><?php echo $dataProduk['warna'] ?></p>
                <p id="product-price">Rp.<?php echo number_format($dataProduk['harga'], 0, ',', '.'); ?></p>
            </div>
            <form action="konfirmasiPembelian.php" method="POST" class="purchase-form">
                <input type="number" name="product" value="<?php echo $id ?>" readonly hidden>
            
                <label for="jumlah">Jumlah Barang:</label>
                <input type="number" name="jumlah">

                <label for="address">Alamat Pengiriman:</label>
                <textarea id="address" name="address" rows="3" required><?php echo $dataPelanggan['alamat']; ?></textarea>

                <label for="payment-method">Metode Pembayaran:</label>
                <input type="text" name="bayar" value="TRANSFER BANK BNI 532432432 a/n Pemilik" readonly> 

                <button type="submit" class="buy-now-button">PESAN SEKARANG</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
</body>
</html>