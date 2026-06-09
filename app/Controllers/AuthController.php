<?php

// ==========================================
// 1. FUNGSI REGISTRASI
// ==========================================
function register($conn) {
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = secure($_POST["username"]); 
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        require_once __DIR__ . '/../models/User.php';
        $userSama = cekUsernameSama($conn, $username);

        if ($userSama) {
            $message = "Gagal: Username sudah digunakan!";
        } else {
            $simpan = daftarkanUserBaru($conn, $username, $password);
            if ($simpan) {
                $message = "Registrasi berhasil! Silakan login.";
            } else {
                $message = "Gagal mendaftar!";
            }
        }
    }
    include __DIR__ . '/../views/auth/register.php';
}


// ==========================================
// 2. FUNGSI LOGIN
// ==========================================
function login($conn) {
    if (isset($_SESSION["username"])) {
        header("Location: index.php?url=dashboard");
        exit();
    }

    if (!isset($_SESSION["username"]) && isset($_COOKIE["user_login"])) {
        $_SESSION["username"] = $_COOKIE["user_login"];
        header("Location: index.php?url=dashboard");
        exit();
    }

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = secure($_POST["username"]);
        $password = $_POST["password"];

        try {
            require_once __DIR__ . '/../models/User.php';
            $user = getUserByUsername($conn, $username);

            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["username"] = $user["username"];

                    if (password_needs_rehash($user["password"], PASSWORD_DEFAULT)) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        updatePasswordUser($conn, $user["username"], $newHash);
                    }

                    if (isset($_POST['remember'])) {
                        setcookie("user_login", $user['username'], time() + (86400 * 7), "/");
                    } else {
                        if (isset($_COOKIE['user_login'])) {
                            setcookie("user_login", "", time() - 3600, "/");
                        }
                    }
                    
                    header("Location: index.php?url=dashboard");
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
    include __DIR__ . '/../views/auth/login.php';
}


// ==========================================
// 3. FUNGSI LOGOUT
// ==========================================
function logout($conn) {

    $_SESSION = array();
    session_destroy();

    if (isset($_COOKIE['user_login'])) {
        setcookie("user_login", "", time() - 3600, "/");
    }

    header("Location: index.php?url=login");
    exit();
}
?>