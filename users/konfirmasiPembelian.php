<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Sukses</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>WEBSITE PENJUALAN JAM TANGAN</h1>
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

            $id = $_POST['product'];
            $jumlah = $_POST['jumlah'];
            $alamat = $_POST['address'];
            $dataProduk = tampilByIdProduk($conn, $id);
            $dataPelanggan = tampilPelanggan($conn, $email);

            
            if($jumlah <= $dataProduk['stock']){
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])){
                $password = $_POST['password'];
                if($password == $dataPelanggan['password']){

                    $hasil = beli($conn, $id, $email, $jumlah, $alamat);

                    if($hasil!=False){
                        header('location: success.php?idTransaksi='.$hasil);
                    }else{
                        echo "<script type='text/javascript'> window.alert('Penyimpanan Gagal') 
                    window.location.href = 'buy.php?product=".$id."';
                    </script>";
                    }
                }
                else{
                    echo "<script type='text/javascript'> window.alert('Password Salah') 
                    window.location.href = 'buy.php?product=".$id."';
                    </script>";
                }
            }
            }else{
                echo "<script type='text/javascript'> window.alert('Jumlah Produk Dibeli Melebihi Stock') 
                    window.location.href = 'buy.php?product=".$id."';
                    </script>";
            }
            $totalHarga = number_format($dataProduk['harga'] * $jumlah, 0, ',', '.');
        ?>
        <div class="purchase-container">
            <h2>Detail Pembelian</h2>
            <div class="product-details">
                <img id="product-image" src="<?php echo $dataProduk['foto'];?>" alt="<?php echo $dataProduk["nama"] ?>">
                <p id="product-name"> <?php echo $dataProduk["nama"] ?> </p>
                <p id="product-color"><?php echo $dataProduk['warna'] ?></p>
                <p id="product-price">Rp.<?php echo number_format($dataProduk['harga'], 0, ',', '.'); ?></p>
            </div>
            <form action="konfirmasiPembelian.php" method="POST" class="purchase-form">
                <input readonly type="number" name="product" value="<?php echo $id ?>" readonly hidden>
            
                <label for="jumlah">Jumlah Barang:</label>
                <input readonly type="number" name="jumlah" value="<?php echo $jumlah ?>" readonly>

                <label for="total">Total Harga:</label>
                <input readonly type="text" name="harga" value="<?php echo "Rp.".$totalHarga ?>" readonly>

                <label for="address">Alamat Pengiriman:</label>
                <textarea id="address" name="address" rows="3" value="<?php $alamat ?>" required><?php echo $alamat ?></textarea>

                <label for="payment-method">Metode Pembayaran:</label>
                <input readonly type="text" name="bayar" value="TRANSFER BANK BNI 532432432 a/n Pemilik" readonly> 

                <label for="password">Konfirmasi Password:</label>
                <input type="text" name="password" placeholder="Masukan Password Untuk konfirmasi Pembelian">

                <button type="submit" class="buy-now-button">PESAN SEKARANG</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
</body>
</html>
