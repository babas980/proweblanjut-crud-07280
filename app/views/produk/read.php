<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body class="body-form">

<div class="container">
    <div class="card-form">
        <h3 class="text-center mb-4 fw-bold">Detail Data Produk</h3>
        
        <div class="mb-4 text-center">
            <?php if (!empty($data['gambar'])): ?>
                <img src="../uploads/<?php echo htmlspecialchars($data['gambar']); ?>" class="img-preview" style="width: 150px; height: 150px; margin: 0 auto; object-fit: cover; border-radius: 8px;">
            <?php else: ?>
                <div class="text-muted small">Tidak ada gambar</div>
            <?php endif; ?>
        </div>

        <form>
            <div class="mb-3">
                <label class="form-label fw-bold">Kode Produk</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['kode_produk']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Produk</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_produk']); ?>" readonly>
            </div>

            <div class="row">
                <div class="col-kiri mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['kategori']); ?>" readonly>
                </div>
                <div class="col-kanan mb-3">
                    <label class="form-label fw-bold">Harga Jual</label>
                    <input type="text" class="form-control" value="Rp <?php echo number_format($data['harga_jual'], 0, ',', '.'); ?>" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-kiri mb-3">
                    <label class="form-label fw-bold">Stok</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['stok']); ?> Unit" readonly>
                </div>
                <div class="col-kanan mb-3">
                    <label class="form-label fw-bold">Tanggal Input</label>
                    <input type="text" class="form-control" value="<?php echo isset($data['create_at']) ? date('d F Y', strtotime($data['create_at'])) : date('d F Y'); ?>" readonly>
                </div>
            </div>

            <div class="button-group-area">
                <a href="index.php?url=edit_produk&id=<?php echo $data['id_produk']; ?>" class="btn-update" style="text-align: center; text-decoration: none;">Edit Produk</a>
                <a href="index.php?url=dashboard" class="btn-batal" style="text-align: center; text-decoration: none;">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>