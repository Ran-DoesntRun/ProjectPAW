<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Produk</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function movepage() {
            window.location.href = "index.php";
        }
    </script>
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

        if(insertProduct($id,$conn, $nama, $harga, $merk, $warna, $stock, $foto_product, $tmpFile)){
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
            <button type="kembali" class="submit-btn kembali" onclick="movepage()">Kembali</button>
        </div>
    </div>
</body>
</html>