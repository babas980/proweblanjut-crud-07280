<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="../public/assets/css/auth.css">
</head>
<body>

    <div class="login-box">
        <h2>Login Ke Sistem</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red; font-size: 14px; text-align: center; margin-top: 0;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label>Username:</label>
                <input type="text" name="username" required autocomplete="off" 
                    value="<?php echo isset($_COOKIE['user_login']) ? htmlspecialchars($_COOKIE['user_login'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            </div>
            
            <div class="input-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="remember" id="remember" <?php echo isset($_COOKIE['user_login']) ? 'checked' : ''; ?>>
                <label for="remember" style="font-size: 13px; color: #666; margin: 0; cursor: pointer;">Ingat Saya</label>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>

        <button type="button" class="btn-register" onclick="window.location.href='index.php?url=register'">
            Daftar Akun Baru
        </button>
    </div>

</body>
</html>