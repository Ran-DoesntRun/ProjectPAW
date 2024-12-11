<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    include "hal_proses.php";

    session_start();

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit;
    }

    $jumlahAllProduct = count(tampil_produk($conn));
    $transaksi = tampil_transaksi($conn);
    $jumlahTransaksi = count($transaksi);
    $jumlahPelanggan = count(tampil_pelanggan($conn));
    $jumlahTransaksiBerhasilBayar = $jumlahTransaksiProsesBayar = $jumlahTransaksiGagalBayar = 
    $jumlahTransaksiBerhasilKirim = $jumlahTransaksiProsesKirim = $jumlahTransaksiGagalKirim = 0;
    foreach($transaksi as $data){
        if($data['statusBayar']=="berhasil") $jumlahTransaksiBerhasilBayar+=1;
        elseif($data['statusBayar']=="proses") $jumlahTransaksiProsesBayar+=1;
        else{$jumlahTransaksiGagalBayar+=1;}

        if($data['statusPengiriman']=="berhasil") $jumlahTransaksiBerhasilKirim+=1;
        elseif($data['statusPengiriman']=="proses") $jumlahTransaksiProsesKirim+=1;
        else{$jumlahTransaksiGagalKirim+=1;}
    }
    ?>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="profile.png" alt="Logo" class="logo-img">
                <h2>WatchStore</h2>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="form_produk.php">Form Produk</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="search-bar">
                    <input type="text" placeholder="Cari...">
                    <button>Cari</button>
                </div>
                <div class="user-info">
                    <p>Hi, Administrator!</p>
                </div>
            </div>
            <div class="dashboard">
                <h1>Halaman Dashboard</h1>
                <div class="stats">
                    <a href="view-all-products.php"><div class="card anotherbg">
                        <p>Jumlah Produk</p>
                        <h2><?php echo $jumlahAllProduct; ?></h2>
                    </div>
                    </a>
                    <a href="view-transaksi-proses.php">
                        <div class="card anotherbg">
                        <p>Jumlah Transaksi</p>
                        <h2><?php echo $jumlahTransaksi; ?></h2>
                    </div>
                    </a>
                    
                    <div class="card anotherbg">
                        <p>Jumlah Pelanggan</p>
                        <h2><?php echo $jumlahPelanggan; ?></h2>
                    </div>
                    </div>
                <h2>Jumlah Transaksi Berdasarkan Status Pembayaran</h2>
                <div class="stats">
                    <div class="card anotherbg">
                        <p>Berhasil</p>
                        <h2><?php echo $jumlahTransaksiBerhasilBayar; ?></h2>
                    </div>
                    <div class="card anotherbg">
                        <p>Proses</p>
                        <h2><?php echo $jumlahTransaksiProsesBayar; ?></h2>
                    </div>
                    <div class="card anotherbg">
                        <p>Gagal</p>
                        <h2><?php echo $jumlahTransaksiGagalBayar; ?></h2>
                    </div>
                </div>
                <h2>Jumlah Transaksi Berdasarkan Status Pengiriman</h2>
                <div class="stats">
                    <div class="card anotherbg">
                        <p>Berhasil</p>
                        <h2><?php echo $jumlahTransaksiBerhasilKirim; ?></h2>
                    </div>
                    <div class="card anotherbg">
                        <p>Proses</p>
                        <h2><?php echo $jumlahTransaksiProsesKirim; ?></h2>
                    </div>
                    <div class="card anotherbg">
                        <p>Gagal</p>
                        <h2><?php echo $jumlahTransaksiGagalKirim; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>