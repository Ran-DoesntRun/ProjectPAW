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

function tampil_transaksi_by_idTransaksi($conn, $id){
    $sql = "SELECT * FROM transaksi WHERE idTransaksi = '$id'";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}

function tampilByIdProduk($conn, $id){
    $sql = "SELECT * FROM produk WHERE idProduk = $id";
    $result = $conn -> query($sql);

    return $result->fetch_assoc();
}

function cetakProduk($prd){
    echo "<tr>";
    echo "<td>" . $prd['idProduk'] . "</td>";
    echo "<td>" . $prd['nama'] . "</td>";
    echo "<td>" . $prd['harga'] . "</td>";
    echo "<td>" . $prd['merk'] . "</td>";
    echo "<td>" . $prd['warna'] . "</td>";
    echo "<td>" . $prd['stock'] . "</td>";
    echo "</tr>";
}

function cetakPelanggan($plg){
    echo "<tr>";
        echo "<td>" . $plg['email'] . "</td>";
        echo "<td>" . $plg['nama'] . "</td>";
        echo "<td>" . $plg['alamat'] . "</td>";
        echo "<td>" . $plg['NoTelp']. "</td>";
    echo "</tr>";
}

function cetakTransaksi($trk, $table){
    echo "<tr>";
    echo "<td>" . $trk['idTransaksi'] . "</td>";
    echo "<td>" . $trk['idProduk'] . "</td>";
    echo "<td>" . $trk['email'] . "</td>";
    echo "<td>" . $trk['jumlah'] . "</td>";
    echo "<td>" . $trk['tglBeli'] . "</td>";
    echo '<form action="index.php" method="POST">';          
    echo '<input type="text" name="table" hidden value="'.$table .'">';
    echo '<input type="text" name="idTransaksi" value="'.$trk['idTransaksi'].'" hidden>';
    echo '<td> <select name="statusBayar">';
    echo '<option value="berhasil" '. ( $trk['statusBayar'] == 'berhasil' ? "SELECTED" : "" ).' >BERHASIL</option>';
    echo '<option value="proses" '. ( $trk['statusBayar'] == 'proses' ? "SELECTED" : "" ).' >PROSES</option>';
    echo '</select>';
    echo '</td>';
    echo "<td>" . $trk['alamatKirim'] . "</td>";
    echo '<td> <select name="statusPengiriman">';
    echo '<option value="berhasil" '. ( $trk['statusPengiriman'] == 'berhasil' ? "SELECTED" : "" ).' >BERHASIL</option>';
    echo '<option value="proses" '. ( $trk['statusPengiriman'] == 'proses' ? "SELECTED" : "" ).' >PROSES</option>';
    echo '</select>';
    echo '<button type="submit" name="SUBMIT">SUBMIT</button>';
    echo '</td></form>';
    echo "</tr>";
}

function editTransaksi($conn, $id, $statusBayar, $statusKirim){

    $sql = "UPDATE transaksi SET statusBayar = '$statusBayar', statusPengiriman = '$statusKirim' WHERE idTransaksi = $id;";
    if ($conn->query($sql) === TRUE) {
        return $id;
    } else {
        return $conn->error;
    }
}

function timeDiff($start_date) {
    date_default_timezone_set('Asia/Jakarta');
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime(date("Y-m-d G:i:s"));

    $difference_in_seconds = abs($end_timestamp - $start_timestamp);
    $difference_in_minutes = $difference_in_seconds / 60;

    return $difference_in_minutes;
}

function editStock($conn, $id){
    $data = tampilByIdProduk($conn, $id);
    $new_stock = ($data['stock'] + 1);
    $sql = "UPDATE produk SET stock = '$new_stock'  WHERE idProduk = $id";
    
    $conn -> query($sql);
}

function deleteTransaksi($conn, $id, $idProduk){
    $sql = "DELETE FROM transaksi WHERE idTransaksi = $id";

    if ($conn->query($sql) === TRUE) {
        editStock($conn, $idProduk);
            return $id;
        } else {
            return $conn->error;
        }
    }
?>