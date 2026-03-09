<?php

include 'connection.php';

if(isset($_GET['id'])){
$id = $_GET['id'];

$query = mysqli_query($connection, "SELECT * FROM produk Where id_produk = '$id'");
$data  = mysqli_fetch_assoc($query);

  if(!$data){
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
  }
}else {
  header("Location: index.php?status");
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

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" readonly>
                            <option value="Elektronik" <?php echo ($data['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                            <option value="Pakaian" <?php echo ($data['kategori'] == 'Pakaian') ? 'selected' : ''; ?>>Pakaian</option>
                            <option value="Alat Tulis" <?php echo ($data['kategori'] == 'Alat Tulis') ? 'selected' : ''; ?>>Alat Tulis</option>
                            <option value="Lainnya" <?php echo ($data['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" value="<?php echo $data['harga_jual']; ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?php echo $data['stok']; ?>" readonly>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="index.php" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>