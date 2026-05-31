<?php
// api/read.php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET"); 

require_once __DIR__ . '/../../config/database.php'; 
require_once __DIR__ . '/../../app/models/BarangModel.php';

if (!isset($conn)) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Koneksi database gagal dimuat."
    ]);
    exit();
}

try {
    $stmt = getAll($conn); 

    $data_barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200); 
    echo json_encode([
        "status" => true,
        "message" => "Berhasil mengambil seluruh data barang.",
        "data" => $data_barang
    ]);

} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode([
        "status" => false,
        "message" => "Gagal mengambil data dari database: " . $e->getMessage()
    ]);
}
?>