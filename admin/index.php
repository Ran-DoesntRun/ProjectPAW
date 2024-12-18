<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
include "hal_proses.php";  // Include the file where functions are defined
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch product, transaction, and customer data
$allProduct = tampil_produk($conn);
$transaksi = tampil_transaksi($conn);
$pelanggan = tampil_pelanggan($conn);
$jumlahAllProduct = count($allProduct);
$jumlahTransaksi = count($transaksi);
$jumlahPelanggan = count($pelanggan);

// Initialize counters for transaction statuses
$jumlahTransaksiBerhasilBayar = $jumlahTransaksiProsesBayar = $jumlahTransaksiGagalBayar = 
$jumlahTransaksiBerhasilKirim = $jumlahTransaksiProsesKirim = $jumlahTransaksiGagalKirim = 0;

// Loop through transactions and count status occurrences
foreach ($transaksi as $data) {
    if ($data['statusBayar'] == "berhasil") $jumlahTransaksiBerhasilBayar++;
    elseif ($data['statusBayar'] == "proses") $jumlahTransaksiProsesBayar++;
    else $jumlahTransaksiGagalBayar++;

    if ($data['statusPengiriman'] == "berhasil") $jumlahTransaksiBerhasilKirim++;
    elseif ($data['statusPengiriman'] == "proses") $jumlahTransaksiProsesKirim++;
    else $jumlahTransaksiGagalKirim++;
}

// Handle POST requests for updating transactions or product stock
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['statusBayar'])) {
        $idt = $_POST['idTransaksi'];
        $hasilEdit = editTransaksi($conn, $idt, $_POST['statusBayar'], $_POST['statusPengiriman']);
        if ($hasilEdit == true) {
            header('location: index.php?table=transaksi&idTransaksi=' . $idt);
        } else {
            echo $hasilEdit;
        }
    } elseif (isset($_POST['stock'])) {
        $idp = $_POST['idProduk'];
        $hasilEdit = editStock($conn, $idp, $_POST['stock']);
        if ($hasilEdit == true) {
            header('location: index.php?table=produk&idProduk=' . $idp);
        } else {
            echo $hasilEdit;
        }
    }
}
?>

    <div>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
            
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

                <!-- Transaksi Payment and Shipping Status -->
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

                <!-- Dynamic Content Based on Table -->
                <?php
                if (isset($_GET['table'])) {
                    $table = $_GET['table'];

                    if ($table == 'produk') { ?>
                        <h2>Data Produk</h2>
                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                            <thead>
                                <tr>
                                    <form action="" method="GET">
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
                            <>
                                <?php foreach ($allProduct as $prd) {
                                    if ($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET['idProduk'])) {
                                        if ($prd['idProduk'] == $_GET['idProduk']) {
                                            cetakProduk($prd);
                                        }
                                    } else {
                                        cetakProduk($prd);
                                    }
                                } ?>
                            
                            </tbody>
                        </table>
                    <?php }elseif ($table == 'pelanggan') { ?>
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
                                    <th>Total</th>
                                    <th>Tanggal Beli</th>
                                    <th>Status Bayar</th>
                                    <th>Alamat Kirim</th>
                                    <th>Status Pengiriman</th>
                                    <th>Tombol Submit</th>
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
                                    deleteTransaksi($conn, $trk['idTransaksi'], $trk['idProduk'], $trk['jumlah']);
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
               
