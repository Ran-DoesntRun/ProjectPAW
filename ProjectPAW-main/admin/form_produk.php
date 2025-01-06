<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Produk</title>
    <script>
        function movepage() {
            window.location.href = "index.php";
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-form h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            width: 100%;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .submit-btn.kembali {
            background-color: #f44336;
            margin-top: 10px;
        }

        .submit-btn.kembali:hover {
            background-color: #d32f2f;
        }

        @media (max-width: 600px) {
            .product-form h1 {
                font-size: 1.5rem;
            }

            .submit-btn {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php 
    session_start();

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include "hal_proses.php";
        $id = $_POST['id'];
        $nama = $_POST['productName'];
        $harga = $_POST['productPrice'];
        $merk = $_POST['brand'];
        $warna = $_POST['warna'];
        $stock = $_POST['stock'];
        $foto_product = $_FILES['productImage']['name'];
        $tmpFile = $_FILES['productImage']['tmp_name'];

        if(insertProduct($id, $conn, $nama, $harga, $merk, $warna, $stock, $foto_product, $tmpFile)){
            echo "<script>";
            echo "window.alert('Produk Berhasil Disimpan')";
            echo "</script>";
        }else{
            echo "<script>";
            echo "window.alert('Produk Gagal Disimpan')";
            echo "</script>";
        }
    }
    ?>
    <div class="container">
        <div class="product-form">
            <h1>Form Produk</h1>
            <form action="form_produk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id">ID Product</label>
                    <input type="text" id="id" name="id" placeholder="Masukkan ID produk" required>
                </div>
                <div class="form-group">
                    <label for="productName">Nama Jam</label>
                    <input type="text" id="productName" name="productName" placeholder="Masukkan nama produk" required>
                </div>
                <div class="form-group">
                    <label for="productPrice">Harga Jam</label>
                    <input type="number" id="productPrice" name="productPrice" placeholder="Masukkan harga produk" required>
                </div>
                <div class="form-group">
                    <label for="brand">Brand Jam</label>
                    <input type="text" id="brand" name="brand" placeholder="Masukkan brand produk" required>
                </div>
                <div class="form-group">
                    <label for="warna">Warna Jam</label>
                    <input type="text" id="warna" name="warna" placeholder="Masukkan warna produk" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock Jam</label>
                    <input type="number" id="stock" name="stock" placeholder="Masukkan jumlah stock produk" required>
                </div>
                <div class="form-group">
                    <label for="productImage">Gambar Jam</label>
                    <input type="file" id="productImage" name="productImage" required>
                </div>
                <button type="submit" class="submit-btn">Simpan Produk</button>
            </form>
            <button type="button" class="submit-btn kembali" onclick="movepage()">Kembali</button>
        </div>
    </div>
</body>
</html>
