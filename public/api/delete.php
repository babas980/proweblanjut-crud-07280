<?php

//Header (Izinkan DELETE atau POST)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, POST");

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/BarangModel.php';

$data_mentah = file_get_contents("php://input");
$data = json_decode($data_mentah, true);

if (empty($data)) {
    $data = $_POST;
}

if (!empty($data['id_produk'])) {
    
    $id = htmlspecialchars(strip_tags($data['id_produk']));

    try {
        // gunakan hapusProdukById()
        if (hapusProdukById($conn, $id)) {
            http_response_code(200); // 200 OK
            echo json_encode([
                "status" => true,
                "message" => "Data barang berhasil dihapus."
            ]);
        } else {
            http_response_code(503); 
            echo json_encode([
                "status" => false,
                "message" => "Gagal menghapus data. Pastikan ID ditemukan."
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
    http_response_code(400); // Bad Request
    echo json_encode([
        "status" => false,
        "message" => "Gagal menghapus data. Parameter 'id_produk' wajib disertakan."
    ]);
}
?>