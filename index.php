<?php
include 'connection.php'; // Menghubungkan ke database
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventory - CALT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #003366; } /* Warna biru elegan */
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">INVENTORY SEDERHANA</a>
    </div>
</nav>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3>Daftar Stok Produk</h3>
        </div>
        <div class="col-md-6 text-end">
            <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
        </div>
    </div>

    <div class="card p-3">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>no</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query ambil data produk
                $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
                $result = mysqli_query($connection, $sql);
                $no = 1;

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . $row['kode_produk'] . "</td>
                                <td>" . $row['nama_produk'] . "</td>
                                <td>" . $row['kategori'] . "</td>
                                <td>" . $row['stok'] . "</td>
                                <td>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>
                                <td>
                                    <a href='edit_produk.php?id=" . $row['id_produk'] . "' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='hapus_produk.php?id=" . $row['id_produk'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Belum ada data produk.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>