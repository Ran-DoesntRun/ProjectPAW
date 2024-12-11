<?php
include '../database.php';

function insertProduct($id, $conn, $nama, $harga, $merk, $warna, $stock, $namaFoto, $pathServer){
$folder = '../product_pict/' ;
$path = $folder.basename($namaFoto);

if(move_uploaded_file($pathServer, $path)){
    $sql = "INSERT INTO produk (idproduk, nama, harga, merk, warna, stock, foto) 
            VALUES ('$id', '$nama', '$harga', '$merk', '$warna', '$stock', '$path')";

    if ($conn -> query($sql) === TRUE) {
        return True;
    } else {
        return 'Error: ' . $sql . '<br>' . $conn->error;
    }
}
}

function tampil_produk($conn){
    $sql = 'SELECT * FROM produk';
    $result = $conn->query($sql);

    $produk = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }
    }
    return $produk;
}

function tampil_pelanggan($conn){
    $sql = 'SELECT * FROM pelanggan';
    $result = $conn->query($sql);

    $pelanggan = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pelanggan[] = $row;
        }
    }
    return $pelanggan;
}

function register($conn, $username, $password){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_check = "SELECT * FROM admin WHERE username = '$username'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                return True;
            } else {
                $error = "Terjadi kesalahan: " . $conn->error;
            }
            return $error;
        }
}


function login($conn,$username, $password){
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            return True;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
    return $error;
}
function tampil_transaksi($conn){
    $sql = 'SELECT * FROM transaksi';
    $result = $conn->query($sql);

    $transaksi = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksi[] = $row;
        }
    }
    return $transaksi;
}

function tampil_transaksi_status_pengiriman($conn, $status){
    $sql = "SELECT * FROM transaksi WHERE statusPengiriman = '$status'";
    $result = $conn->query($sql);

    $transaksi = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksi[] = $row;
        }
    }
    return $transaksi;
}

function tampil_transaksi_status_pembayaran($conn, $status){
    $sql = "SELECT * FROM transaksi WHERE statusBayar = '$status'";
    $result = $conn->query($sql);

    $transaksi = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksi[] = $row;
        }
    }
    return $transaksi;
}

function tampil_transaksi_by_email($conn, $email){
    $sql = "SELECT * FROM transaksi WHERE email = '$email'";
    $result = $conn->query($sql);

    $transaksi = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transaksi[] = $row;
        }
    }
    return $transaksi;
}
?>