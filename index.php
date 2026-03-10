<?php
include 'connection.php'; // Pastikan file koneksi sudah benar
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALT | Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f4f7f6; 
            font-family: 'Poppins', sans-serif;
        }
        .navbar { 
            background-color: #003366; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card { 
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: #003366;
            border: none;
        }
        .btn-primary:hover {
            background-color: #002244;
        }
        .search-container {
            max-width: 400px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-5">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">CALT INVENTORY</a>
    </div>
</nav>

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-5">
            <h3 class="fw-bold m-0 text-dark">Daftar Stok Produk</h3>
        </div>
        
        <div class="col-md-7">
            <form action="" method="GET" class="d-flex justify-content-end gap-2">
                <div class="input-group search-container">
                    <input type="text" name="cari" class="form-control" 
                           placeholder="Cari nama atau kode..." 
                           value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    
                    <?php if(isset($_GET['cari'])): ?>
                        <a href="index.php" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </div>
                
                <a href="create.php" class="btn btn-success text-nowrap">+ Tambah Produk</a>
            </form>
        </div>
    </div>

    <div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Logika Pencarian
                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                        $sql = "SELECT * FROM produk WHERE 
                                nama_produk LIKE '%$cari%' OR 
                                kode_produk LIKE '%$cari%' OR 
                                kategori LIKE '%$cari%'
                                ORDER BY id_produk DESC";
                    } else {
                        $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
                    }

                    $result = mysqli_query($connection, $sql);
                    $no = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $no++ . "</td>
                                    <td><span class='fw-bold'>" . $row['kode_produk'] . "</span></td>
                                    <td>" . $row['nama_produk'] . "</td>
                                    <td>" . $row['kategori'] . "</td>
                                    <td>" . $row['stok'] . "</td>
                                    <td>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>
                                    <td class='text-center'>
                                        <div class='btn-group'>
                                            <a href='read.php?id=" . $row['id_produk'] . "' class='btn btn-sm btn-info text-white'>Detail</a>
                                            <a href='edit.php?id=" . $row['id_produk'] . "' class='btn btn-sm btn-warning'>Edit</a>
                                            <a href='delete.php?id=" . $row['id_produk'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")'>Hapus</a>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Data tidak ditemukan atau belum ada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>