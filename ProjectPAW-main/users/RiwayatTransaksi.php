<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(12, 11, 6);
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 50px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .header-buttons button,
        .header-buttons a {
            margin: 0 5px;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .header-buttons button:hover,
        .header-buttons a:hover {
            background-color: #0056b3;
        }


        /* Search Bar */
        .search-bar {
            margin: 20px auto;
            text-align: center;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 5px;
        }

        .search-bar button {
            padding: 10px 15px;
            font-size: 1rem;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #218838;
        }

        /* Order Card Container */
        .order-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 900px;
        }

        .order-item {
            display: flex;
            align-items: center;
        }

        .order-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .order-details h3, .order-details h4 {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .order-details p {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .order-summary {
            text-align: right;
        }

        .order-summary p {
            margin: 5px 0;
            font-size: 1rem;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .order-card a:hover {
            background-color: #0056b3;
        }

        .order-card a{
            background-color: #007BFF;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .order-card {
                flex-direction: column;
                text-align: center;
            }

            .order-item {
                flex-direction: column;
            }

            .order-item img {
                margin-bottom: 10px;
            }

            .order-summary {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <?php 
        include "proses.php";

        session_start();
        if (!isset($_SESSION['user'])) {
            header("location: login.php");
            exit;
        }

        $email = $_SESSION['user'];
        $dataTransaksi = tampil_transaksi_by_email($conn, $email);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['dicari'])) {
            $dicari = $_POST['dicari'];
            $dataTransaksi = pencarian_TRANSAKSI($conn, $dicari);
        }
    ?>
    <header>
        <div class="logo">
            <a href="index.php"><h1>WEBSITE PENJUALAN JAM TANGAN</h1></a>
        </div>
        <div class="header-buttons">
            <a href="logout.php">Keluar</a>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="" method="POST">
            <input type="text" name="dicari" placeholder="Masukan Nomor Transaksi ..." required>
            <button type="submit" name="Cari">Cari</button>
        </form>
    </div>

    <!-- Order Cards -->
    <?php 
        foreach ($dataTransaksi as $data) {    
            $idP = $data['idProduk'];
            $dataProduk = tampilByIdProduk($conn, $idP);
    ?>
    <div class="order-card">
        <!-- Order Item -->
        <div class="order-item">
            <img src="<?php echo $dataProduk['foto']; ?>" alt="<?php echo $dataProduk['nama']; ?>">
            <div class="order-details">
                <h3>Nomor Transaksi: <?php echo $data['idTransaksi']; ?></h3>
                <h4><?php echo $dataProduk['nama']; ?></h4>
                <p>Brand: <?php echo $dataProduk['merk']; ?></p>
                <p>Harga: Rp <?php echo number_format($dataProduk['harga'], 0, ',', '.'); ?></p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <p>Status Pembayaran: <?php echo $data['statusBayar']; ?></p>
            <p>Status Pengiriman: <?php echo $data['statusPengiriman']; ?></p>
            <p>Total Pesanan: Rp <?php echo number_format($dataProduk['harga'] * $data['jumlah'], 0, ',', '.'); ?></p>
            <?php if ($data['statusBayar'] == 'proses') { ?>
                <a href="success.php?idTransaksi=<?php echo $data['idTransaksi']; ?>">PEMBAYARAN</a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

</body>
</html>
