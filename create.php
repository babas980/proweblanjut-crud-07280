<?php
session_start();
include 'connection.php'; 

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$nama_barang = "";
$stok = "";
$harga = "";
$kode = "";
$kategori = "";
$errors = [];

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
        $ukuranFile = $_FILES["gambar"]["size"];

        if ($ukuranFile > 10485760) {
            $errors[] = "Ukuran gambar terlalu besar. Maksimal adalah 10 MB.";
        }

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File yang dipilih bukan gambar.";
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ekstensiFile, $allowed)) {
            $errors[] = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        }

        if (empty($errors)) {

            $namalama = str_replace(' ', '_', $namaAsli);
            $namaFileBaru_Proses = uniqid() . "_" . $namalama . "." . $ekstensiFile;
            $target_file = $target_dir . $namaFileBaru_Proses;

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

                // Set notifikasi sukses untuk header.php
                $_SESSION['pesan'] = "Produk berhasil ditambahkan!";
                $_SESSION['tipe'] = "success";

                header("Location: dashboard.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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
        
        <form method="post" enctype="multipart/form-data">
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
                <a href="dashboard.php" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>