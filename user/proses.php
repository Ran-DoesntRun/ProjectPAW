<?php
include '../database.php';

function tampilkanProduk($conn) {
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);

    $produk = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }
    }
    return $produk;
}

function tampilByIdProduk($conn, $id){
    $sql = "SELECT * FROM produk WHERE idProduk = '$id'";
    $result = $conn -> query($sql);

    return $result->fetch_assoc();
}

function tampilPelanggan($conn, $email) {
    $sql = "SELECT * FROM pelanggan WHERE email = '$email'";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}

function daftarPelanggan($conn, $email, $nama, $alamat, $password, $noTelp) {
    $sql = "INSERT INTO pelanggan (email, nama, alamat, password, NoTelp) 
            VALUES ('$email', '$nama', '$alamat', '$password', '$noTelp')";

    if ($conn->query($sql) === TRUE) {
        return True;
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

/* function tampilTransaksiByEmail($conn, $email){
    $sql = "SELECT * FROM pelanggan WHERE email = '$email'"
} */

function loginPelanggan($conn, $email, $password) {
    $sql = "SELECT * FROM pelanggan WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); 
    } else {
        return false; 
    }
}

function beli($conn, $id, $email, $jumlah, $alamatKirim){
    $produk = tampilByIdProduk($conn, $id);
    $total = $produk['harga'] * $jumlah;
    $tgl = date("Y-m-d");

    $status = "proses";

    $sql = "INSERT INTO transaksi (email, jumlah, tglBeli, statusBayar, alamatKirim, idProduk, statusPengiriman) 
            VALUES ('$email', '$jumlah', '$tgl', '$status', '$alamatKirim','$id',  '$status')";
    
    if ($conn->query($sql) === TRUE) {
        return True;
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
