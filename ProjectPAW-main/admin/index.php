<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and Layout */
body {
    font-family: Arial, sans-serif;
    display: flex;
    height: 100vh;
    background-color:rgb(172, 172, 172);
}

/* Sidebar Styles */
.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: #fff;
    padding: 20px;
    height: 100vh;
    position: fixed;
}

.sidebar .logo {
    text-align: center;
}

.sidebar .logo img {
    width: 80px;
    border-radius: 50%;
}

.sidebar .logo h2 {
    margin-top: 10px;
    font-size: 24px;
    font-weight: 600;
}

.sidebar .nav ul {
    list-style: none;
    padding: 0;
}

.sidebar .nav ul li {
    margin: 20px 0;
}
    
.sidebar .nav ul li a {
        color: white;
    }

a {
    color: black;
    text-decoration: none;
    font-size: 18px;
    display: block;
    padding: 10px;
    transition: background-color 0.3s;
}

.sidebar .nav ul li a:hover {
    background-color: #34495e;
}

/* Main Content Area */
.main-content {
    margin-left: 250px;
    padding: 20px;
    width: 100%;
    height: 100vh;
    overflow-y: auto;
}

/* Header Section */
.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.search-bar input {
    padding: 10px;
    font-size: 16px;
    width: 300px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.search-bar button {
    padding: 10px 15px;
    background-color: #3498db;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 10px;
}

.search-bar button:hover {
    background-color: #2980b9;
}

.user-info p {
    font-size: 18px;
    font-weight: bold;
}

/* Dashboard Stats Section */
.dashboard {
    margin-bottom: 30px;
}

.dashboard h1 {
    font-size: 30px;
    margin-bottom: 20px;
    color: #333;
}

.card {
    background-color: #ecf0f1;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card h2 {
    font-size: 36px;
    font-weight: bold;
    color: #2c3e50;
}

.card p {
    font-size: 18px;
    color: #7f8c8d;
}

/* Additional Card Styling for Status */
.anotherbg {
    background-color: #f39c12;
    color: #fff;
}

.anotherbg:hover {
    background-color: #e67e22;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color:rgb(30, 34, 37);
    color: white;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #34495e;
}

/* Form Input and Button Styles */
input[type="text"] {
    padding: 8px;
    width: 250px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button[type="submit"] {
    padding: 8px 15px;
    background-color:rgb(32, 32, 32);
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 10px;
}

button[type="submit"]:hover {
    background-color:rgb(81, 81, 81);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 10px;
    }

    .main-content {
        margin-left: 0;
    }

    .stats {
        flex-direction: column;
    }

    .card {
        width: 100%;
        margin-bottom: 20px;
    }

    a:active, a:hover, a:visited, a:link{
        text-decoration: none;
    }

    a:hover{
        background-color: #34495e;
    }
}

    </style>
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
        $hasilEdit = editStock($conn, $idp, $_POST['stock'], 'ubah');
        if ($hasilEdit == true) {
            header('location: index.php?table=produk&idProduk=' . $idp);
        } else {
            echo $hasilEdit;
        }
    }
}
?>

    <div class="container">
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
            
        <h1>Halaman Dashboard</h1>

<!-- Tabel Jumlah Produk, Transaksi, dan Pelanggan -->
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Data</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Jumlah Produk</td>
            <td><?php echo $jumlahAllProduct; ?></td>
            <td><a href="index.php?table=produk">Lihat Detail</a></td>
        </tr>
        <tr>
            <td>Jumlah Transaksi</td>
            <td><?php echo $jumlahTransaksi; ?></td>
            <td><a href="index.php?table=transaksi">Lihat Detail</a></td>
        </tr>
        <tr>
            <td>Jumlah Pelanggan</td>
            <td><?php echo $jumlahPelanggan; ?></td>
            <td><a href="index.php?table=pelanggan">Lihat Detail</a></td>
        </tr>
    </tbody>
</table>

<!-- Tabel Transaksi Berdasarkan Status Pembayaran -->
<h2>Jumlah Transaksi Berdasarkan Status Pembayaran</h2>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Status Pembayaran</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Berhasil</td>
            <td><?php echo $jumlahTransaksiBerhasilBayar; ?></td>
            <td><a href="index.php?table=transaksi&filter=pembayaran&status=berhasil">Lihat Detail</a></td>
        </tr>
        <tr>
            <td>Proses</td>
            <td><?php echo $jumlahTransaksiProsesBayar; ?></td>
            <td><a href="index.php?table=transaksi&filter=pembayaran&status=proses">Lihat Detail</a></td>
        </tr>
    </tbody>
</table>

<!-- Tabel Transaksi Berdasarkan Status Pengiriman -->
<h2>Jumlah Transaksi Berdasarkan Status Pengiriman</h2>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Status Pengiriman</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Berhasil</td>
            <td><?php echo $jumlahTransaksiBerhasilKirim; ?></td>
            <td><a href="index.php?table=transaksi&filter=pengiriman&status=berhasil">Lihat Detail</a></td>
        </tr>
        <tr>
            <td>Proses</td>
            <td><?php echo $jumlahTransaksiProsesKirim; ?></td>
            <td><a href="index.php?table=transaksi&filter=pengiriman&status=proses">Lihat Detail</a></td>
        </tr>
    </tbody>
</table>

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
                        <?php 
                        foreach ($transaksi as $trk){
                         if(timeDiff($trk['tglBeli']) > 1440 && $trk['statusBayar'] == "proses"){
                            deleteTransaksi($conn, $trk['idTransaksi'], $trk['idProduk'], $trk['jumlah']);
                        }
                        }
                        ?>
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
               
