<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>
<body>

<nav class="navbar mb-5">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
        <a class="navbar-brand" href="index.php?url=dashboard">INVENTORY</a>
        
        <ul class="navbar-nav">
            <li class="profile-dropdown" style="position: relative;">
                <a class="nav-link" href="#">
                    <span class="text-white small" style="margin-right: 8px;"><?php echo htmlspecialchars($namaUser); ?></span>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($namaUser); ?>&background=random&color=fff" 
                         alt="Profile" class="profile-img">
                </a>
                <ul class="dropdown-menu">
                    <li><h6 class="dropdown-header">Profil Saya</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="index.php?url=logout">
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-kiri">
            <h3 class="fw-bold m-0 text-dark">Daftar Stok Produk</h3>
            <h5>Selamat datang <?php echo htmlspecialchars($namaUser); ?></h5>
        </div>
        
        <div class="col-kanan">
            <form action="" method="GET" class="d-flex justify-content-end gap-2">
                <input type="hidden" name="url" value="dashboard">
                
                <div class="search-container">
                    <input type="text" name="cari" class="form-control" 
                           placeholder="Cari nama atau kode..." 
                           value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    
                    <?php if(isset($_GET['cari'])): ?>
                        <a href="index.php?url=dashboard" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </div>
                
                <a href="index.php?url=tambah_produk" class="btn btn-success text-nowrap" style="margin-left: 8px;">+ Tambah Produk</a>
            </form>
        </div>
    </div>

<div class="card p-4">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
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
                $no = 1;

                if ($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $tampilanGambar = "";
                        if (!empty($row['gambar'])) {
                            $tampilanGambar = "<img src='../uploads/" . htmlspecialchars($row['gambar']) . "' style='width: 30px; height: 30px; object-fit:cover; border-radius:5px;'>";
                        }
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . $tampilanGambar . "</td> 
                                <td><span class='fw-bold'>" . htmlspecialchars($row['kode_produk']) . "</span></td>
                                <td>" . htmlspecialchars($row['nama_produk']) . "</td>
                                <td>" . htmlspecialchars($row['kategori']) . "</td>
                                <td>" . htmlspecialchars($row['stok']) . "</td>
                                <td>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>
                                <td class='text-center'>
                                    <div class='btn-group'>
                                        <a href='index.php?url=detail_produk&id=" . $row['id_produk'] . "' class='btn btn-info text-white'>Detail</a>
                                        <a href='index.php?url=edit_produk&id=" . $row['id_produk'] . "' class='btn btn-warning'>Edit</a>
                                        <a href='index.php?url=hapus_produk&id=" . $row['id_produk'] . "' class='btn btn-danger' onclick='return confirm(\"Yakin ingin menghapus produk ini?\")'>Hapus</a>
                                    </div>
                                </td>
                                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center py-4 text-muted'>Data tidak ditemukan atau belum ada.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>