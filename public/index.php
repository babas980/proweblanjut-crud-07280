<?php

session_start();

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
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        login($conn); 
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
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        index($conn);
        break;

    case 'tambah_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        create();
        break;

    case 'simpan_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        store($conn); 
        break;

    case 'detail_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        read($conn); 
        break;

    case 'edit_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        edit($conn); 
        break;

    case 'update_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        update($conn);
        break;

    case 'hapus_produk':
        require_once __DIR__ . '/../app/Controllers/ProdukController.php';
        destroy($conn);
        break;

    default:
        echo "<h3>Halaman tidak ditemukan! (Error 404)</h3>";
        echo "<a href='index.php'>Kembali ke Home</a>";
        break;
}
?>