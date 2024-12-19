<?php
include 'hal_proses.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hasil = login($conn, $username, $password);
    if ($hasil) {
            session_start();
            $_SESSION['admin'] = $username;
            header("Location: index.php");
        } else {
            echo "<script>";
            echo "window.alert('$hasil')";
            echo "</script>";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="lore.css">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Login Admin</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Email</label>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="email" id="username" name="username" placeholder="Masukkan username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <p>Belum memiliki akun? <a href="register.php" class="link">Daftar di sini</a></p>
    </div>
</body>
</html>

