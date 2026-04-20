<?php
session_start();
include 'connection.php'; 

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

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
            // Set notifikasi sukses untuk header.php
            $_SESSION['pesan'] = "Data produk berhasil diperbarui!";
            $_SESSION['tipe'] = "success";
            
            header("Location: dashboard.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['pesan'] = "Gagal mengupdate: " . $e->getMessage();
        $_SESSION['tipe'] = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="body-form"> <div class="container">
    <div class="card-form">
        <h3 class="text-center mb-4 fw-bold">Edit Data Produk</h3>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                
                <?php if (!empty($data['gambar'])): ?>
                    <div class="mb-2">
                        <img src="uploads/<?php echo $data['gambar']; ?>" class="img-preview">
                        <p class="text-muted" style="font-size: 12px;">Gambar saat ini</p>
                    </div>
                <?php endif; ?>
                
                <input type="file" name="gambar" class="form-control">
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
                <a href="dashboard.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>