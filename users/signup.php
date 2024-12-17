<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1>Daftar</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="signup-form">
            <h2>Buat Akun Baru</h2>
            <form action="action.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" required>
                <label for="noTelp">Nomor Telepon:</label>
                <input type="text" id="noTelp" name="noTelp" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="daftar">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Watch Store. All rights reserved.</p>
    </footer>
</body>

</html>