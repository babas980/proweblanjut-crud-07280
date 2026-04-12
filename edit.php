<?php
session_start();

include 'connection.php'; 

if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit();
}

// Ambil id dari url 
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        header("Location: dashboard.php");
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $kode     = $_POST['kode_produk'];
    $nama     = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga    = $_POST['harga_jual'];
    $stok     = $_POST['stok'];

    $namaFileBaru = $data['gambar'];

    if ($_FILES['gambar']['error'] === 0) {
        $target_dir = "uploads/";
        $namaAsli = pathinfo($_FILES["gambar"]["name"], PATHINFO_FILENAME);
        $ekstensiFile = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));

        $namaFileBaru = uniqid() . "_" . str_replace(' ', '_', $namaAsli) . "." . $ekstensiFile;
        $target_file = $target_dir . $namaFileBaru;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            if (!empty($data['gambar']) && file_exists($target_dir . $data['gambar'])) {
                unlink($target_dir . $data['gambar']);
            }
        }
    }

    try {
        $sql = "UPDATE produk SET 
                kode_produk = ?, 
                nama_produk = ?, 
                kategori    = ?, 
                harga_jual  = ?, 
                stok        = ?, 
                gambar      = ?
                WHERE id_produk = ?";
        
        $stmt_update = $conn->prepare($sql);
        $params = [$kode, $nama, $kategori, $harga, $stok, $namaFileBaru, $id];
        
        if ($stmt_update->execute($params)) {
            header("Location: dashboard.php?status=update_berhasil");
            exit;
        }
    } catch (PDOException $e) {
        echo "Gagal mengupdate: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - CALT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            color: white;
            display: flex;
            align-items: center;
        }
        .card { 
            background: rgba(255, 255, 255, 0.95); 
            color: #333; 
            border-radius: 15px;
        }
        .btn-warning { background-color: #f39c12; border: none; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center mb-4 fw-bold">Edit Produk</h3>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Produk</label>
                        
                        <?php if (!empty($data['gambar'])): ?>
                            <div class="mb-2">
                                <img src="uploads/<?php echo $data['gambar']; ?>" width="100" class="img-thumbnail d-block mb-1">
                                <small class="text-muted">Gambar saat ini</small>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" name="gambar" class="form-control">                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Produk</label>
                        <input type="text" name="kode_produk" class="form-control" value="<?php echo $data['kode_produk']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?php echo $data['nama_produk']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Smartphone" <?php echo ($data['kategori'] == 'Smartphone') ? 'selected' : ''; ?>>Smartphone</option>
                            <option value="Laptop" <?php echo ($data['kategori'] == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                            <option value="Aksesoris" <?php echo ($data['kategori'] == 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris</option>
                            <option value="Komponen PC" <?php echo ($data['kategori'] == 'Komponen PC') ? 'selected' : ''; ?>>Komponen PC</option>
                            <option value="Perangkat Input" <?php echo ($data['kategori'] == 'Perangkat Input') ? 'selected' : ''; ?>>Perangkat Input</option>
                            <option value="Lainnya" <?php echo ($data['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?php echo $data['harga_jual']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?php echo $data['stok']; ?>" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>