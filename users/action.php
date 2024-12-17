<?php
include "../database.php";
include "proses.php";
    if (isset($_POST['daftar'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];
        $noTelp = $_POST['noTelp'];
        $password = $_POST['password'];

        $pesan = daftarPelanggan($conn,  $email, $username, $alamat,  $password, $noTelp);
        if($pesan = True){
            header("location:login.php");
        }
    }
    ?>