<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';

// Ambil parameter halaman dari URL
$page = isset($_GET['url']) ? $_GET['url'] : 'home';

switch ($page) {
    case 'home':
        include '../app/views/home/index.php';
        break;

    case 'login':
        include '../app/views/auth/login.php';
        break;

    case 'register':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        register($conn); 
        break;

    case 'logout':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        logout($conn);
        break;

    case 'dashboard':
        include '../app/views/produk/index.php';
        break;

    case 'tambah_produk':
        include '../app/views/produk/create.php';
        break;

    case 'edit_produk':
        include '../app/views/produk/edit.php';
        break;

    default:
        echo "<h3>Halaman tidak ditemukan! (Error 404)</h3>";
        echo "<a href='index.php'>Kembali ke Home</a>";
        break;
}
?>