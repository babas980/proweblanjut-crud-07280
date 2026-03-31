<?php
include "connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);


$check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$check_stmt->execute([$username]);
$check_result = $check_stmt->fetch();

if ($check_result) {
    $message = "Gagal: Username sudah digunakan!";
} else {
    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    
    if ($stmt->execute([$username, $password])) {
        $message = "Registrasi berhasil!";
    } else {
        $message = "Gagal mendaftar!";
    }
}
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Registrasi</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background:  #003366;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 300px;
        }

        .register-box h2 {
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

        .btn-register {
            background-color: #28a745; 
            color: white;
        }

        .btn-back {
            background-color: #e2e8f0;
            color: #333;
            margin-top: 15px;
        }

        .msg-info {
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <div class="register-box">
        <h2>Daftar Akun</h2>

        <?php if ($message): ?>
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
            
            <button type="submit" class="btn-register">Daftar Sekarang</button>
        </form>

        <button type="button" class="btn-back" onclick="window.location.href='login.php'">
            Sudah punya akun? Login
        </button>
    </div>

</body>
</html>