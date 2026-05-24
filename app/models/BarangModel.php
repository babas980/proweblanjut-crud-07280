<?php
// app/models/Produk.php

function getAll($conn) {
    $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
    return $conn->query($sql);
}

function getById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function save($conn, $kode, $nama, $kategori, $harga, $stok, $gambar) {
    $sql = "INSERT INTO produk (kode_produk, nama_produk, kategori, harga_jual, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$kode, $nama, $kategori, $harga, $stok, $gambar]);
}

function updateProduk($conn, $id, $kode, $nama, $kategori, $harga, $stok, $gambar) {
    $sql = "UPDATE produk SET kode_produk = ?, nama_produk = ?, kategori = ?, harga_jual = ?, stok = ?, gambar = ? WHERE id_produk = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$kode, $nama, $kategori, $harga, $stok, $gambar, $id]);
}

function hapusProdukById($conn, $id) {
    $sql = "DELETE FROM produk WHERE id_produk = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$id]);
}

function cariProduk($conn, $cari) {
    $sql = "SELECT * FROM produk WHERE nama_produk LIKE ? OR kode_produk LIKE ? OR kategori LIKE ? ORDER BY id_produk DESC";
    $stmt = $conn->prepare($sql);
    $keyword = "%$cari%";
    $stmt->execute([$keyword, $keyword, $keyword]);
    return $stmt;
}
?>