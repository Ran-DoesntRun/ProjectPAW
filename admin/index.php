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
    

    $allProduct = tampil_produk($conn);
    $transaksi = tampil_transaksi($conn);
    $pelanggan = tampil_pelanggan($conn);
    $jumlahAllProduct = count($allProduct);
    $jumlahTransaksi = count($transaksi);
    $jumlahPelanggan = count($pelanggan);
    $jumlahTransaksiBerhasilBayar = $jumlahTransaksiProsesBayar = $jumlahTransaksiGagalBayar = 
    $jumlahTransaksiBerhasilKirim = $jumlahTransaksiProsesKirim = $jumlahTransaksiGagalKirim = 0;
    foreach ($transaksi as $data) {
        if ($data['statusBayar'] == "berhasil") $jumlahTransaksiBerhasilBayar += 1;
        elseif ($data['statusBayar'] == "proses") $jumlahTransaksiProsesBayar += 1;
        else {
            $jumlahTransaksiGagalBayar += 1;
        }

        if ($data['statusPengiriman'] == "berhasil") $jumlahTransaksiBerhasilKirim += 1;
        elseif ($data['statusPengiriman'] == "proses") $jumlahTransaksiProsesKirim += 1;
        else {
            $jumlahTransaksiGagalKirim += 1;
        }
    }

    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['statusBayar'])){
        $idt = $_POST['idTransaksi'];
        echo $_POST['statusBayar'];
        $data = tampil_transaksi_by_idTransaksi($conn, $idt);
        $hasilEdit = editTransaksi($conn, $idt, $_POST['statusBayar'], $_POST['statusPengiriman']);
        if($hasilEdit == True){
            header('location: index.php?table=transaksi&idTransaksi='.$idt);
        }else{
            echo $hasilEdit;
        }
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
                    <a href="index.php?table=produk">
                        <div class="card anotherbg">
                            <p>Jumlah Produk</p>
                            <h2><?php echo $jumlahAllProduct; ?></h2>
                        </div>
                    </a>
                    <a href="index.php?table=transaksi">
                        <div class="card anotherbg">
                            <p>Jumlah Transaksi</p>
                            <h2><?php echo $jumlahTransaksi; ?></h2>
                        </div>
                    </a>
                    <a href="index.php?table=pelanggan">
                        <div class="card anotherbg">
                            <p>Jumlah Pelanggan</p>
                            <h2><?php echo $jumlahPelanggan; ?></h2>
                        </div>
                    </a>
                </div>
                <h2>Jumlah Transaksi Berdasarkan Status Pembayaran</h2>
                <div class="stats">
                    <a href="index.php?table=transaksi&filter=pembayaran&status=berhasil">
                        <div class="card anotherbg">
                            <p>Berhasil</p>
                            <h2><?php echo $jumlahTransaksiBerhasilBayar; ?></h2>
                        </div>
                    </a>
                    <a href="index.php?table=transaksi&filter=pembayaran&status=proses">
                        <div class="card anotherbg">
                            <p>Proses</p>
                            <h2><?php echo $jumlahTransaksiProsesBayar; ?></h2>
                        </div>
                    </a>
                </div>
                <h2>Jumlah Transaksi Berdasarkan Status Pengiriman</h2>
                <div class="stats">
                    <a href="index.php?table=transaksi&filter=pengiriman&status=berhasil">
                        <div class="card anotherbg">
                            <p>Berhasil</p>
                            <h2><?php echo $jumlahTransaksiBerhasilKirim; ?></h2>
                        </div>
                    </a>
                    <a href="index.php?table=transaksi&filter=pengiriman&status=proses">
                        <div class="card anotherbg">
                            <p>Proses</p>
                            <h2><?php echo $jumlahTransaksiProsesKirim; ?></h2>
                        </div>
                    </a>
                    <a href="index.php?table=transaksi&filter=pengiriman&status=gagal">
                        <div class="card anotherbg">
                            <p>Gagal</p>
                            <h2><?php echo $jumlahTransaksiGagalKirim; ?></h2>
                        </div>
                    </a>
                </div>

                <?php 
                if(isset($_GET['table']) || $_SERVER['REQUEST_METHOD'] == "POST"){
                    if(isset($_GET['table'])){
                    $table = $_GET['table'];
                    }else{
                         $table = $_POST['table'];
                    }
                    if($table == 'produk'){ ?>
                        <!-- Tambahan Tabel Pelanggan -->
                        <h2>Data Produk</h2>
                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <form action="" method="POST">
                                    <input type="text" name="table" hidden value="<?php echo $table ?>">
                                    <th><input type="text" name="idProduk" placeholder="Id Produk">
                                    <button type="submit" name="CARI">CARI...</button></th>
                                    </form>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Merk</th>
                                    <th>Warna</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                        foreach($allProduct as $prd){
                            if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['idProduk'])){
                                if($prd['idProduk'] == $_POST['idProduk']){
                                    cetakProduk($prd);
                                }
                            }else{
                                cetakProduk($prd);
                            }
                        }

                    }elseif ($table == 'pelanggan') { ?>
                        <!-- Tambahan Tabel Pelanggan -->
                        <h2>Data Pelanggan</h2>
                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <form action="" method="POST">
                                    <input type="text" name="table" hidden value="<?php echo $table ?>">
                                    <th><input type="text" name="email" placeholder="Email">
                                    <button type="submit" name="CARI">CARI...</button></th>
                                    </form>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Nomor Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                        foreach($pelanggan as $plg){
                            if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['email'])){
                                if($plg['email'] == $_POST['email']){
                                    cetakPelanggan($plg);
                                }
                            }else{
                                cetakPelanggan($plg);
                            }
                        }
                    }elseif($table == 'transaksi'){ ?>
                        <!-- Tambahan Tabel Transaksi -->
                        <h2>Data Transaksi</h2>
                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <form action="" method="POST">
                                    <input type="text" name="table" hidden value="<?php echo $table ?>">
                                    <th><input type="text" name="idTransaksi" placeholder="ID Transaksi">
                                    <button type="submit" name="CARI">CARI...</button></th>
                                    </form>
                                    <th>ID Produk</th>
                                    <th>Email Pelanggan</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Beli</th>
                                    <th>Status Bayar</th>
                                    <th>Alamat Kirim</th>
                                    <th>Status Pengiriman</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php if(isset($_GET['filter'])){
                            $filter = $_GET['filter'];
                            $status = $_GET['status'];
                            if($filter == 'pembayaran'){
                                foreach($transaksi as $trk){
                                    if($trk['statusBayar']==$status){
                                        cetakTransaksi($trk, $table);
                                    }
                                }
                            }else{
                                foreach($transaksi as $trk){
                                    if($trk['statusPengiriman']==$status){
                                        cetakTransaksi($trk,$table);
                                    }
                                }
                            }
                        }else{
                            foreach ($transaksi as $trk) {
                            if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['idTransaksi'])){
                                if($trk['idTransaksi'] == $_POST['idTransaksi']){
                                    cetakTransaksi($trk, $table);
                                }
                            }else{
                                if(timeDiff($trk['tglBeli']) > 1440 && $trk['statusBayar'] == "proses"){
                                    deleteTransaksi($conn, $trk['idTransaksi'], $trk['idProduk']);
                                }
                                cetakTransaksi($trk, $table);
                            }
                        }
                        }
                    }
                }
            ?>
                
                        <?php 
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>