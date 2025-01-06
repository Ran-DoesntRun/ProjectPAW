<?php
include 'hal_proses.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $error = "";
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

    if (empty($confirm_password)) {
        $error = "Konfirmasi Password tidak boleh kosong!";
    } elseif ($password != $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok!";
    }

    if (!empty($error)) {
        echo "<script>";
        echo "window.alert('$error');";
        echo "window.history.back();";
        echo "</script>";
    } else {
        if (register($conn, $username, $password)) {
            echo "<script>";
            echo "window.alert('Pendaftaran Berhasil');";
            echo "window.location.href='login.php';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "window.alert('Pendaftaran Gagal');";
            echo "</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link rel="stylesheet" href="lore.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Admin Baru</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Email</label>
                <div class="input-container">
                <input type="email" id="username" name="username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-container">
                <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <div class="input-container">
                <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
            <button type="submit" class="submit-btn">Daftar</button>
        </form>
        <p>Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>
