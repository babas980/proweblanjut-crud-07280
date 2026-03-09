<?php
include 'connection.php';

// 1. AMBIL ID DARI URL
if (isset($_GET['id'])) {
$id = $_GET['id'];

// 2. TARIK DATA LAMA UNTUK DITAMPILKAN DI FORM
$sql = "DELETE FROM produk WHERE id_produk = '$id'";


    if (mysqli_query($connection, $sql)) {
        header("Location: index.php?status=hapus_berhasil");
    } else {
        echo "Gagal menghapus: " . mysqli_error($connection);
    }
}else{
  header("Location: index.php");
}

?>

