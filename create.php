<?php
session_start();

include 'connection.php'; 

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$nama_barang ="";
$stok ="";
$harga ="";
$kode = "";
$kategori ="";
$errors=[];

$namaFileBaru = isset($_POST['gambar_temp']) ? $_POST['gambar_temp'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    $kode        = trim($_POST['kode_produk']);
    $nama_barang = trim($_POST['nama_produk']);
    $kategori    = trim($_POST['kategori']);
    $harga       = trim($_POST['harga_jual']);
    $stok        = trim($_POST['stok']);

    if (empty($nama_barang)) {
        $errors[] = "Nama barang tidak boleh kosong.";
    }

    if (!is_numeric($stok)) {
        $errors[] = "Jumlah stok harus berupa angka.";
    }
    
    if (!is_numeric($harga)) {
        $errors[] = "Harga harus berupa angka.";
    }

    if ($_FILES['gambar']['error'] === 0) {
        
        $target_dir = "uploads/";
        $namaAsli = pathinfo($_FILES["gambar"]["name"], PATHINFO_FILENAME);
        $ekstensiFile = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $namalama = str_replace(' ', '_', $namaAsli);
        $namaFileBaru_Proses = uniqid() . "_" . $namalama . "." . $ekstensiFile;
        $target_file = $target_dir . $namaFileBaru_Proses;

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File yang dipilih bukan gambar.";
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ekstensiFile, $allowed)) {
            $errors[] = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $namaFileBaru = $namaFileBaru_Proses;    
            } else {
                $errors[] = "Terjadi kesalahan saat mengunggah file.";
            }
        }
    }

    if (empty($errors)) {
        if (empty($namaFileBaru)) {
            $errors[] = "Silahkan pilih gambar produk.";
        } else {
            try {
                $sql = "INSERT INTO produk (kode_produk, nama_produk, kategori, harga_jual, stok, gambar) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$kode, $nama_barang, $kategori, $harga, $stok, $namaFileBaru]);

                header("Location: dashboard.php?status=sukses");
                exit();
            } catch (PDOException $e) {
                $errors[] = "Gagal menyimpan ke database: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - CALT</title>
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .btn-primary { background: linear-gradient(to right, #4e54c8, #8f94fb); border: none; }
    </style>
</head>
<body>

<!--FORM PENGISIAN DATA PRODUK -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center mb-4 fw-bold">Tambah Produk Baru</h3>

                <?php if (!empty($errors)): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 20px;">
                        <strong>Terjadi Kesalahan:</strong>
                        <ul style="margin-top: 5px;">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-bold">gambar Produk</label>
                        <?php if (!empty($namaFileBaru)): ?>
                            <div class="mb-2">
                                <img src="uploads/<?php echo $namaFileBaru; ?>" width="100" class="img-thumbnail d-block mb-1">
                                <input type="hidden" name="gambar_temp" value="<?php echo $namaFileBaru; ?>">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Produk</label>
                        <input type="text" name="kode_produk" class="form-control" placeholder="Contoh: BRG001" value="<?php echo htmlspecialchars($kode); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" placeholder="Nama barang..." value="<?php echo htmlspecialchars($nama_barang); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Smartphone" <?php echo ($kategori == 'Smartphone') ? 'selected' : ''; ?>>Smartphone</option>
                            <option value="Laptop" <?php echo ($kategori == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                            <option value="Aksesoris" <?php echo ($kategori == 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris</option>
                            <option value="Komponen PC" <?php echo ($kategori == 'Komponen PC') ? 'selected' : ''; ?>>Komponen PC</option>
                            <option value="Perangkat Input" <?php echo ($kategori == 'Perangkat Input') ? 'selected' : ''; ?>>Perangkat Input</option>
                            <option value="Lainnya" <?php echo ($kategori == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" placeholder="0" value="<?php echo htmlspecialchars($harga); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" placeholder="0" value="<?php echo htmlspecialchars($stok); ?>" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Produk</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>