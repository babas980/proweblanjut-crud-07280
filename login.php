<?php
session_start();

if (!isset($_SESSION["username"]) && isset($_COOKIE["user_login"])) {
    $_SESSION["username"] = $_COOKIE["user_login"];
    
    header("Location: dashboard.php");
    exit();
}

include "connection.php"; 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["username"] = $user["username"];

                if (isset($_POST['remember'])) {
                    $nama_user = $user['username']; 
                    setcookie("user_login", $nama_user, time() + (86400 * 7), "/");
                } else {
                    if (isset($_COOKIE['user_login'])) {
                        setcookie("user_login", "", time() - 3600, "/");
                    }
                }
                header("Location: dashboard.php");
                exit(); 
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan database: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Halaman Login</title>

<style>
        body {
            font-family: Arial, sans-serif;
            background: #003366;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 300px;
        }

        .login-box h2 {
            text-align: center;
            margin-top: 0;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #666;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-register {
            background-color: #e2e8f0; 
            color: #333;
            margin-top: 15px;
        }
    </style>
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
                    value="<?php echo isset($_COOKIE['user_login']) ? htmlspecialchars($_COOKIE['user_login']) : ''; ?>">
            </div>
            
            <div class="input-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="remember" id="remember" 
                    <?php echo isset($_COOKIE['user_login']) ? 'checked' : ''; ?>>
                <label for="remember" style="font-size: 13px; color: #666; margin: 0; cursor: pointer;">Ingat Saya</label>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>

        <button type="button" class="btn-register" onclick="window.location.href='register.php'">
            Daftar Akun Baru
        </button>
    </div>

</body>
</html>