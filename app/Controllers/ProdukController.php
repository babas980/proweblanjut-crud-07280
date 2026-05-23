<?php
require_once __DIR__ . '/../models/Produk.php';

function index($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    $namaUser = $_SESSION["username"];

    if (isset($_GET['cari']) && !empty($_GET['cari'])) {
        $cari = secure($_GET['cari']);
        $stmt = cariProduk($conn, $cari);
    } else {
        $stmt = getAll($conn);
    }
    include __DIR__ . '/../views/produk/index.php';
}

function create() {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    
    $kode = ""; $nama_barang = ""; $kategori = ""; $harga = ""; $stok = ""; $errors = [];
    include __DIR__ . '/../views/produk/create.php';
}

function store($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kode        = trim($_POST['kode_produk']);
        $nama_barang = trim($_POST['nama_produk']);
        $kategori    = trim($_POST['kategori']);
        $harga       = trim($_POST['harga_jual']);
        $stok        = trim($_POST['stok']);
        $errors      = [];
        $namaFileBaru = "";

        if (empty($nama_barang)) { $errors[] = "Nama barang tidak boleh kosong."; }
        if (!is_numeric($stok)) { $errors[] = "Jumlah stok harus berupa angka."; }
        if (!is_numeric($harga)) { $errors[] = "Harga harus berupa angka."; }

        if ($_FILES['gambar']['error'] === 0) {
            $target_dir = "../uploads/";
            $namaAsli = pathinfo($_FILES["gambar"]["name"], PATHINFO_FILENAME);
            $ekstensiFile = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
            
            if (empty($errors)) {
                $namaFileBaru = uniqid() . "_" . str_replace(' ', '_', $namaAsli) . "." . $ekstensiFile;
                move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $namaFileBaru);
            }
        }

        if (empty($errors) && !empty($namaFileBaru)) {
            save($conn, $kode, $nama_barang, $kategori, $harga, $stok, $namaFileBaru); 
            $_SESSION['pesan'] = "Produk berhasil disimpan!";
            header("Location: index.php?url=dashboard");
            exit();
        } else {
            include __DIR__ . '/../views/produk/create.php';
        }
    }
}

function read($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    $id = secure($_GET['id']);
    $data = getById($conn, $id);
    if (!$data) { header("Location: index.php?url=dashboard"); exit(); }
    include __DIR__ . '/../views/produk/read.php';
}

function edit($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    $id = secure($_GET['id']);
    $data = getById($conn, $id); 
    $errors = [];
    include __DIR__ . '/../views/produk/edit.php';
}

function update($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    $id = secure($_GET['id']);
    $data = getById($conn, $id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kode     = trim($_POST['kode_produk']);
        $nama     = trim($_POST['nama_produk']);
        $kategori = $_POST['kategori'];
        $harga    = trim($_POST['harga_jual']);
        $stok     = trim($_POST['stok']);
        $namaFileBaru = $data['gambar'];
        $errors = [];

        if (empty($nama)) { $errors[] = "Nama produk tidak boleh kosong."; }
        if (!is_numeric($harga) || $harga < 0) { $errors[] = "Harga jual harus angka positif."; }
        if (!is_numeric($stok) || $stok < 0) { $errors[] = "Stok harus angka positif."; }

        if (empty($errors) && $_FILES['gambar']['error'] === 0) {
            $target_dir = "../uploads/";
            $namaUnik = uniqid() . "_" . str_replace(' ', '_', pathinfo($_FILES["gambar"]["name"], PATHINFO_FILENAME)) . "." . strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir . $namaUnik)) {
                if (!empty($data['gambar']) && file_exists($target_dir . $data['gambar'])) { unlink($target_dir . $data['gambar']); }
                $namaFileBaru = $namaUnik;
            }
        }

        if (empty($errors)) {
            updateProduk($conn, $id, $kode, $nama, $kategori, $harga, $stok, $namaFileBaru);
            $_SESSION['pesan'] = "Produk berhasil diperbarui!";
            header("Location: index.php?url=dashboard");
            exit();
        } else {
            include __DIR__ . '/../views/produk/edit.php';
        }
    }
}

function destroy($conn) {
    if (!isset($_SESSION["username"])) { header("Location: index.php?url=login"); exit(); }
    $id = secure($_GET['id']);
    $data = getById($conn, $id);
    
    if ($data) {
        $target_dir = "../uploads/";
        if (!empty($data['gambar']) && file_exists($target_dir . $data['gambar'])) { unlink($target_dir . $data['gambar']); }
        hapusProdukById ($conn, $id); 
    }
    header("Location: index.php?url=dashboard");
    exit();
}
?>