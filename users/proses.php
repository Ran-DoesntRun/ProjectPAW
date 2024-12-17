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
    date_default_timezone_set('Asia/Jakarta');
    $produk = tampilByIdProduk($conn, $id);
    $total = $produk['harga'] * $jumlah;
    $tgl = date("Y-m-d G:i:s");

    $status = "proses";

    $sql = "INSERT INTO transaksi (email, jumlah, tglBeli, statusBayar, alamatKirim, idProduk, statusPengiriman, total) 
            VALUES ('$email', '$jumlah', '$tgl', '$status', '$alamatKirim','$id',  '$status', '$total')";
    
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $dummy = editStock($conn, $id, $jumlah);
        return $last_id;
    } else {
        return False;
    }
}

function editStock($conn, $id, $jumlah){
    $data = tampilByIdProduk($conn, $id);
    $new_stock = ($data['stock'] - $jumlah);
    $sql = "UPDATE produk SET stock = '$new_stock'  WHERE idProduk = $id";
    
    if($conn -> query($sql) === TRUE){
        return True;
    }else{
        return False;
    }
}

function pencarian_PRODUK($conn, $filter, $dicari){
    $sql = "SELECT * FROM produk WHERE $filter LIKE '%$dicari%' ORDER BY stock DESC";

    $result = $conn -> query($sql);

    $produk = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }
    }
    return $produk;
}

function pencarian_TRANSAKSI($conn, $dicari){

    $sql = "SELECT * FROM transaksi WHERE idTransaksi = '$dicari'";

    $result = $conn -> query($sql);
    
    $plg = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plg[] = $row;
        }
    }

    return $plg;
}

function batas($tgl){
    date_default_timezone_set('Asia/Jakarta');

    $originalTime = $tgl;
    $dateTime = new DateTime($originalTime);
    $dateTime->modify('+1 hour');
    $newTime = $dateTime->format('Y-m-d H:i:s');
    
    return $newTime;
}

?>
