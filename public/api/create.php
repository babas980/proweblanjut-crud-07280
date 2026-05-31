<?php
// api/create.php

// 1. Atur Header (Hanya izinkan metode POST)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/BarangModel.php';

// 2. Tangkap data yang dikirim oleh Klien (Postman)
// API modern biasanya menerima data murni dalam bentuk JSON di 'php://input'
$data_mentah = file_get_contents("php://input");
$data = json_decode($data_mentah, true);

// Fallback: Jika klien mengirim lewat form standar (x-www-form-urlencoded)
if (empty($data)) {
    $data = $_POST;
}

// 3. Validasi Input: Pastikan field wajib diisi
// (Kita menyesuaikan dengan fungsi save() di modelmu: kode, nama, kategori, harga, stok, gambar)
if (
    !empty($data['kode_produk']) &&
    !empty($data['nama_produk']) &&
    !empty($data['kategori']) &&
    isset($data['harga_jual']) &&
    isset($data['stok'])
) {
    // 4. Sanitasi data untuk keamanan tambahan (mencegah XSS)
    $kode     = htmlspecialchars(strip_tags($data['kode_produk']));
    $nama     = htmlspecialchars(strip_tags($data['nama_produk']));
    $kategori = htmlspecialchars(strip_tags($data['kategori']));
    $harga    = htmlspecialchars(strip_tags($data['harga_jual']));
    $stok     = htmlspecialchars(strip_tags($data['stok']));
    
    // Untuk API sederhana ini, kita anggap gambar dikirim sebagai string (misal nama file default)
    $gambar = !empty($data['gambar']) ? htmlspecialchars(strip_tags($data['gambar'])) : 'default.jpg';

    // 5. Panggil fungsi save() dari BarangModel.php
    try {
        if (save($conn, $kode, $nama, $kategori, $harga, $stok, $gambar)) {
            http_response_code(201); // 201 Created
            echo json_encode([
                "status" => true,
                "message" => "Data barang berhasil ditambahkan."
            ]);
        } else {
            // Jika execute() gagal tapi tidak melempar exception
            http_response_code(503); // 503 Service Unavailable
            echo json_encode([
                "status" => false,
                "message" => "Gagal menyimpan data barang."
            ]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
} else {
    // Jika ada field yang kosong
    http_response_code(400); // 400 Bad Request
    echo json_encode([
        "status" => false,
        "message" => "Gagal menambahkan data. Pastikan semua field terisi."
    ]);
}
?>