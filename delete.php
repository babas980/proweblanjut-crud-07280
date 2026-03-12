<?php
include 'connection.php';

// Ambil id dari url
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Logika menghapus data
        $sql = "DELETE FROM produk WHERE id_produk = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$id])) {
            header("Location: dashboard.php?status=hapus_berhasil");
            exit;
        }
    } catch (PDOException $e) {
        echo "Gagal menghapus: " . $e->getMessage();
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
