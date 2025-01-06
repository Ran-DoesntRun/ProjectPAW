<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Sukses</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        a, a:active, a:visited, a:hover{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="index.php"><h1>WEBSITE PENJUALAN JAM TANGAN</h1></a>
            </div>
        </div>
    </header>

    <main>
        <?php
            include "proses.php";

            session_start();
            if (!isset($_SESSION['user'])) {
                header("location: login.php");
            }
            $email = $_SESSION['user'];
            $id = $_GET['idTransaksi'];

            $transaksi = pencarian_TRANSAKSI($conn, $id)[0];
            $dataProduk = tampilByIdProduk($conn, $transaksi['idProduk']);
            $dataPelanggan = tampilPelanggan($conn, $email);

            $totalHarga = number_format($dataProduk['harga'] * $transaksi['jumlah'], 0, ',', '.');
        ?>
        <div class="purchase-container">
            <h2>Detail Pembelian</h2>
            <div class="product-details">
                <img id="product-image" src="<?php echo $dataProduk['foto'];?>" alt="<?php echo $dataProduk["nama"] ?>">
                <p id="product-name"> <?php echo $dataProduk["nama"] ?> </p>
                <p id="product-color"><?php echo $dataProduk['warna'] ?></p>
                <p id="product-price">Rp.<?php echo number_format($dataProduk['harga'], 0, ',', '.'); ?></p>
                <div class="purchase-container">
    
    <!-- Informasi Pembayaran -->
    <div class="payment-info">
        <h3>SILAHKAN KIRIMKAN BUKTI TRANSFER MELALUI WHATSAPP PADA NOMOR <strong>082144224231</strong></h3>
        <h4>BATAS PENGIRIMAN BUKTI TRANSFER PADA <strong><?php echo batas($transaksi['tglBeli']); ?></strong></h4>
        <p>Sertakan nomor transaksi dibawah ini sebagai pesan tambahan:</p>
    </div>

    <!-- Formulir Konfirmasi Pembelian -->
    <form action="konfirmasiPembelian.php" method="POST" class="purchase-form">
        <label for="idt">Nomor Transaksi</label>
        <input readonly type="number" name="idt" value="<?php echo $id ?>" readonly>

        <label for="jumlah">Jumlah Barang:</label>
        <input readonly type="number" name="jumlah" value="<?php echo $transaksi['jumlah'] ?>" readonly>

        <label for="total">Total Harga:</label>
        <input readonly type="text" name="harga" value="<?php echo "Rp.".$totalHarga ?>" readonly>

        <label for="address">Alamat Pengiriman:</label>
        <textarea readonly id="address" name="address" rows="3"><?php echo $transaksi['alamatKirim'] ?></textarea>

        <label for="payment-method">Metode Pembayaran:</label>
        <input readonly type="text" name="bayar" value="TRANSFER BANK BNI 532432432 a/n Pemilik" readonly> 
    </form>
</div>
