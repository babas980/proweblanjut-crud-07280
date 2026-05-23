<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="body-form">

<div class="container">
    <div class="card-form">
        <h3 class="text-center mb-4 fw-bold">Tambah Produk Baru</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert-danger-custom">
                <strong>Terjadi Kesalahan:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" action="index.php?url=simpan_produk">
                <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" placeholder="Contoh: BRG001" value="<?php echo htmlspecialchars($kode); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" placeholder="Nama barang..." value="<?php echo htmlspecialchars($nama_barang); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php 
                    $list_kategori = ["Smartphone", "Laptop", "Aksesoris", "Komponen PC", "Perangkat Input", "Lainnya"];
                    foreach($list_kategori as $kat): ?>
                        <option value="<?php echo $kat; ?>" <?php echo ($kategori == $kat) ? 'selected' : ''; ?>><?php echo $kat; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-kiri mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" placeholder="0" value="<?php echo htmlspecialchars($harga); ?>" required>
                </div>
                <div class="col-kanan mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" placeholder="0" value="<?php echo htmlspecialchars($stok); ?>" required>
                </div>
            </div>

            <div class="button-group-area">
                <button type="submit" name="simpan" class="btn-submit">Simpan Produk</button>
                <a href="index.php?url=dashboard" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>