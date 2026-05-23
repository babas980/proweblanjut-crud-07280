<?php
// app/models/Produk.php

// Fungsi untuk mencari produk berdasarkan keyword
function cariProduk($conn, $cari) {
    $sql = "SELECT * FROM produk WHERE 
            nama_produk LIKE ? OR 
            kode_produk LIKE ? OR 
            kategori LIKE ?
            ORDER BY id_produk DESC";
            
    $stmt = $conn->prepare($sql);
    $keyword = "%$cari%";
    $stmt->execute([$keyword, $keyword, $keyword]);
    return $stmt;
}

function getAllProduk($conn) {
    $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
    return $conn->query($sql);
}
?>