<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="body-form">

<div class="container">
    <div class="card-form">
        <h3 class="text-center mb-4 fw-bold">Edit Data Produk</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert-danger-custom">
                <strong>Gagal Update:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" action="index.php?url=update_produk&id=<?php echo $data['id_produk']; ?>">
            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <?php if (!empty($data['gambar'])): ?>
                    <div class="mb-2">
                        <img src="../uploads/<?php echo $data['gambar']; ?>" class="img-preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                        <p class="text-muted" style="font-size: 11px; margin-top: 3px;">Gambar saat ini</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="gambar" class="form-control">
                <small class="text-muted" style="font-size: 10px;">*Kosongkan jika tidak ingin mengubah gambar (Max 10MB)</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" value="<?php echo htmlspecialchars($data['kode_produk']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="<?php echo htmlspecialchars($data['nama_produk']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <?php 
                    $list_kategori = ["Smartphone", "Laptop", "Aksesoris", "Komponen PC", "Perangkat Input", "Lainnya"];
                    foreach($list_kategori as $kat): ?>
                        <option value="<?php echo $kat; ?>" <?php echo ($data['kategori'] == $kat) ? 'selected' : ''; ?>>
                            <?php echo $kat; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-kiri mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="<?php echo htmlspecialchars($data['harga_jual']); ?>" required>
                </div>
                <div class="col-kanan mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?php echo htmlspecialchars($data['stok']); ?>" required>
                </div>
            </div>

            <div class="button-group-area">
                <button type="submit" name="update" class="btn-update">Update Data</button>
                <a href="index.php?url=dashboard" class="btn-batal" style="text-align: center; text-decoration: none;">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>