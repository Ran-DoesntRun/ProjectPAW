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
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color:rgb(12, 11, 6);
            color: #333;
        }

        /* Header Styles */
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

        /* Banner */
        .banner {
            background: url('banner-image.jpg') no-repeat center center/cover;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }

        .banner-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
        }

        .banner-content select,
        .banner-content input,
        .banner-content button {
            margin: 5px;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
        }

        .banner-content input {
            width: 200px;
        }

        .banner-content button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .banner-content button:hover {
            background-color: #218838;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .product p {
            margin: 10px 0;
            font-size: 1rem;
            color: #555;
        }

        .product .price {
            font-weight: bold;
            color: #28a745;
        }

        .buy-button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .buy-button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                text-align: center;
            }

            .header-buttons {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <h1>WEBSITE PENJUALAN JAM TANGAN</h1>
        </div>
        <div class="header-buttons">
            <a href="RiwayatTransaksi.php" class="cart-icon">🛒</a>
            <?php if (!isset($_SESSION['user'])) { ?>
                <a href="login.php"><button>Masuk</button></a>
                <a href="signup.php"><button>Daftar</button></a>
            <?php } else { ?>
                <a href="logout.php"><button>Keluar</button></a>
            <?php } ?>
        </div>
    </header>

    <section class="banner">
        <div class="banner-content">
            <form action="" method="POST">
                <select class="form-select form-select-lg" name="filter" id="filter">
                    <option selected value="nama">Filter</option>
                    <option value="nama">Nama Produk</option>
                    <option value="merk">Brand</option>
                </select>
                <input type="text" name="dicari" placeholder="Pencarian ...">
                <button type="submit" name="Cari">Cari</button>
            </form>
        </div>
    </section>

    <main>
        <div class="product-grid">
            <?php
            if (count($produk) > 0) {
                foreach ($produk as $item) { ?>
                    <div class="product">
                        <img src="<?php echo $item['foto']; ?>" alt="<?php echo $item['nama']; ?>">
                        <p><?php echo $item['nama']; ?></p>
                        <p class="price"><?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                        <?php if ($item['stock'] > 0) { ?>
                            <a href="buy.php?product=<?php echo $item['idProduk']; ?>" class="buy-button">Beli Sekarang</a>
                        <?php } else { ?>
                            <p>Stock Produk Telah Habis</p>
                        <?php } ?>
                    </div>
            <?php }
            } else { ?>
                <div class="product">
                    <p>Tidak ada data produk.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
</body>
</html>
