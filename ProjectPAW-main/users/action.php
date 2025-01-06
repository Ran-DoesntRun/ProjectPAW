<?php
include "../database.php";
include "proses.php";
if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $noTelp = $_POST['noTelp'];
    $password = $_POST['password'];

    $error = '';

    if (empty($username)) {
        $error = "Username tidak boleh kosong!";
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = "Username harus memiliki panjang antara 3-20 karakter!";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Username hanya boleh berisi huruf, angka, dan underscore!";
    }

    if (empty($email)) {
        $error = "Email tidak boleh kosong!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    }

    if (empty($alamat)) {
        $error = "Alamat tidak boleh kosong!";
    } elseif (strlen($alamat) < 5) {
        $error = "Alamat harus memiliki panjang minimal 5 karakter!";
    }

    if (empty($noTelp)) {
        $error = "Nomor telepon tidak boleh kosong!";
    } elseif (!preg_match('/^\d{10,15}$/', $noTelp)) {
        $error = "Nomor telepon harus berupa angka dengan panjang antara 10-15 digit!";
    }

    if (empty($password)) {
        $error = "Password tidak boleh kosong!";
    } elseif (strlen($password) < 8) {
        $error = "Password harus memiliki panjang minimal 8 karakter!";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "Password harus mengandung setidaknya satu huruf besar!";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = "Password harus mengandung setidaknya satu huruf kecil!";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "Password harus mengandung setidaknya satu angka!";
    } elseif (!preg_match('/[\W]/', $password)) {
        $error = "Password harus mengandung setidaknya satu simbol!";
    }

    if (!empty($error)) {
        echo "<script>";
        echo "window.alert('$error');";
        echo "window.history.back();";
        echo "</script>";
    } else {
        $pesan = daftarPelanggan($conn, $email, $username, $alamat, $password, $noTelp);
        if ($pesan === true) {
            header("Location: login.php");
            exit;
        } else {
            echo "<script>";
            echo "window.alert('Pendaftaran Gagal');";
            echo "window.history.back();";
            echo "</script>";
        }
    }
}

    ?>