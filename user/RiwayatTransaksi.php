
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link rel="stylesheet" href="historyCSS.css">
</head>
<body>
    <?php 
        include "proses.php";

        session_start();
        if (!isset($_SESSION['user'])) {
            header("location: login.php");
        }

        $email = ($_SESSION['user']);
        $dataTransaksi = tampil_transaksi_by_email($conn, $email);
    ?>

    
        <div class="search-bar">
            <input type="text" placeholder="Kamu bisa cari berdasarkan Nama Penjual, No. Pesanan atau Nama Produk">
        </div>
    <?php 
        foreach ($dataTransaksi as $data){    
            $id = $data['idProduk'];
            $dataProduk = tampilByIdProduk($conn, $id);
            ?>
        <div class="order-card">
            <div class="order-item">
                <img src="<?php echo $dataProduk['foto']?>" alt="<?php echo $dataProduk['nama'] ?>">
                <div class="order-details">
                    <h4><?php echo $dataProduk['nama'] ?></h4>
                    <p>Brand: <?php echo $dataProduk['merk'] ?></p>
                    <p><?php $dataProduk['harga'] ?></p>
                </div>
            </div>
            <div class="order-summary">
                <p>Status Pembayaran: 
                    <?php echo $data['statusBayar']?> 
                </p>
                <p>Status Pengiriman: 
                    <?php echo $data['statusPengiriman']?> 
                </p>
                <p>Total Pesanan: 
                <?php echo number_format($dataProduk['harga'] * $data['jumlah'], 0, ',', '.'); ?>
                </p>
            </div>
        </div>
        <?php }
    ?>

</body>
</html>
