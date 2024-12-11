<?php
include 'proses.php';

session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = loginPelanggan($conn, $email, $password);

    if ($user) {
        $_SESSION['user'] = $email;
        header("Location: index.php"); // Redirect to dashboard
        exit();
    } else {
         echo "<script>";
            echo "window.alert('Email/Password Salah')";
            echo "</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Login</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="login-form">
            <h2>Masuk ke Akun Anda</h2>
            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="login">Masuk</button>
            </form>
            <p>Belum punya akun? <a href="signup.php">Daftar sekarang</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
    <?php if (isset($pesan)): ?>
    <p>
        <?= $pesan; ?>
    </p>
    <?php endif; ?>
</body>

</html>