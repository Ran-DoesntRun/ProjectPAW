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
</head>
<body>
    <div class="container">
        <h2>Login Admin</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        <p>Belum memiliki akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
