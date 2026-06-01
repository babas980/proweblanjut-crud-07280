<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, POST");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/BarangModel.php';

$data_mentah = file_get_contents("php://input");
$data = json_decode($data_mentah, true);

if (empty($data)) {
    $data = $_POST;
}

if (
    !empty($data['id_produk']) && 
    !empty($data['kode_produk']) &&
    !empty($data['nama_produk']) &&
    !empty($data['kategori']) &&
    isset($data['harga_jual']) &&
    isset($data['stok'])
) {
    $id       = htmlspecialchars(strip_tags($data['id_produk']));
    $kode     = htmlspecialchars(strip_tags($data['kode_produk']));
    $nama     = htmlspecialchars(strip_tags($data['nama_produk']));
    $kategori = htmlspecialchars(strip_tags($data['kategori']));
    $harga    = htmlspecialchars(strip_tags($data['harga_jual']));
    $stok     = htmlspecialchars(strip_tags($data['stok']));
    $gambar   = !empty($data['gambar']) ? htmlspecialchars(strip_tags($data['gambar'])) : 'default.jpg';

    try {
        if (updateProduk($conn, $id, $kode, $nama, $kategori, $harga, $stok, $gambar)) {
            http_response_code(200); // 200 OK
            echo json_encode([
                "status" => true,
                "message" => "Data barang berhasil diperbarui."
            ]);
        } else {
            http_response_code(503); 
            echo json_encode([
                "status" => false,
                "message" => "Gagal memperbarui data barang. Pastikan ID ditemukan."
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
    http_response_code(400); 
    echo json_encode([
        "status" => false,
        "message" => "Gagal memperbarui data. Pastikan ID dan semua field wajib terisi."
    ]);
}
?>