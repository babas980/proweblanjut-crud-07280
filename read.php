<?php
session_start();

include 'connection.php'; 

if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit();
}

// Logika Pengambilan data dari database menggunakan PDO
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - CALT</title>
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

<!--Logika untuk menampilkan detail data produk-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center mb-4 fw-bold">Detail Produk</h3>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Produk</label>
                        <input type="text" name="kode_produk" class="form-control" value="<?php echo $data['kode_produk']; ?>" readonly>
                    
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?php echo $data['nama_produk']; ?>" readonly>
                    </div>

                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <input type="text" class="form-control bg-light" value="<?php echo $data['kategori']; ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?php echo $data['harga_jual']; ?>" readonly>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tanggal Input</label>
                        <input type="text" class="form-control bg-light" 
                            value="<?php echo date('d F Y, H:i', strtotime($data['create_at'])); ?>" readonly>
                    </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?php echo $data['stok']; ?>" readonly>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="dashboard.php" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>