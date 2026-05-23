<?php
// app/Controllers/ProdukController.php

function tampilDashboard($conn) {
    // 1. PASANG SATPAM: Cek proteksi login
    if (!isset($_SESSION["username"])) {
        header("Location: index.php?url=login");
        exit();
    }

    $namaUser = $_SESSION["username"];

    // Panggil file Model Produk
    require_once __DIR__ . '/../models/Produk.php';

    // 2. Logika penanganan search bar
    if (isset($_GET['cari']) && !empty($_GET['cari'])) {
        $cari = secure($_GET['cari']); // Gunakan fungsi secure() dari config
        $stmt = cariProduk($conn, $cari);
    } else {
        $stmt = getAllProduk($conn);
    }

    // 3. Panggil file View Dashboard produk
    include __DIR__ . '/../views/produk/index.php';
}
?>