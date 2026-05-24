<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="../public/assets/css/auth.css">
</head>
<body>

    <div class="login-box">
        <h2>Daftar Akun</h2>

        <?php if (!empty($message)): ?>
            <div class="msg-info">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label>Username:</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            
            <div class="input-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-register-submit">Daftar Sekarang</button>
        </form>

        <button type="button" class="btn-register" onclick="window.location.href='index.php?url=login'">
            Sudah punya akun? Login
        </button>
    </div>

</body>
</html>