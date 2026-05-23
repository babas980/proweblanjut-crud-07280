# Dokumentasi Proyek Sistem Inventory (MVC Architecture)
**PROWEBLANJUT-CRUD**

Aplikasi manajemen inventori berbasis web ini dikembangkan menggunakan arsitektur **Strict MVC (Model-View-Controller) Prosedural** dengan PHP dan MySQL (PDO) sebagai bagian dari penerapan standar *clean code* dan *separation of concerns* pada aplikasi web.

---

## Struktur Direktori & Daftar Fungsi File

Proyek ini menerapkan pemisahan total antara logika bisnis, pengelolaan database, dan tampilan antarmuka. Berikut adalah penjelasan fungsi tiap direktori dan file penting:

### 1. Root & Konfigurasi Utama
- **`public/index.php`**: Satu-satunya pintu masuk aplikasi (*Single Entry Point*) yang bertindak sebagai **Router** pusat untuk mengelola alur halaman berdasarkan parameter URL.
- **`config/database.php`**: Menyimpan konfigurasi koneksi database MySQL menggunakan PDO (*PHP Data Objects*) serta fungsi dekontaminasi/keamanan input data.
- **`uploads/`**: Tempat penyimpanan terpusat untuk berkas fisik gambar/foto produk yang diunggah oleh pengguna.
- **`filedatabase.sql`**: Berkas script database untuk proses import skema tabel pengguna dan produk ke MySQL/phpMyAdmin.

### 2. Lapisan Logika Bisnis (`app/Controllers/`)
- **`AuthController.php`**: Mengatur seluruh logika autentikasi pengguna, meliputi fungsi `login()`, `register()`, serta pembersihan sesi dan kuki pada fungsi `logout()`.
- **`ProdukController.php`**: Mengontrol alur data produk, manajemen berkas unggahan gambar menggunakan `move_uploaded_file()`, penghapusan aset via `unlink()`, serta pembatasan hak akses (*session guard*) halaman dashboard.

### 3. Lapisan Query Database (`app/models/`)
- **`User.php`**: Berisi fungsi-fungsi spesifik database untuk entitas pengguna, seperti pengecekan ketersediaan username dan pengambilan data kredensial untuk verifikasi kata sandi.
- **`Produk.php`**: Berisi seluruh kumpulan query SQL murni (*Prepared Statements*) untuk operasi CRUD tabel produk, termasuk fungsi pencarian (*search bar filters*).

### 4. Lapisan Antarmuka (`app/views/`)
- **`views/auth/`**: Menampung file tampilan murni untuk halaman `login.php` dan `register.php`.
- **`views/home/`**: Menampung file tampilan halaman utama aplikasi (`index.php`).
- **`views/produk/`**: Menampung seluruh antarmuka manajemen produk, meliputi tabel stok utama (`index.php`), formulir tambah (`create.php`), edit data (`edit.php`), dan rincian produk (`read.php`).

### 5. Aset Statis (`assets/`)
- **`assets/css/`**: Berisi file `style.css` untuk tata letak aplikasi dan `auth.css` untuk standardisasi visual kotak dialog autentikasi sistem.

---

## Fitur Utama Sistem

* **Autentikasi Aman**: Registrasi akun menggunakan enkripsi `password_hash()` dan verifikasi `password_verify()`.
* **Sesi Terproteksi**: Dukungan manajemen *Session* PHP serta fitur *Remember Me* menggunakan kuki terenkripsi.
* **Manajemen Hak Akses**: Pembatasan halaman dashboard (pengguna tidak sah otomatis dialihkan kembali ke pintu login).
* **Siklus CRUD Terintegrasi**: Ditunjang dengan fitur validasi tipe data input, pembatasan ukuran unggahan berkas gambar (Maks. 10MB), serta pembersihan berkas lama otomatis saat data dihapus atau diubah.
* **Pencarian Multi-Kolom**: Penyaringan data inventori instan berdasarkan nama produk, kode produk, ataupun kategori.

---

## Teknologi Pengembangan

- **Bahasa Pemrograman**: PHP 8.x (Native dengan Pola Desain MVC)
- **Database Management**: MySQL / MariaDB (Driver PDO)
- **Antarmuka (UI)**: HTML5, CSS3, Google Fonts (Poppins)
- **Manajemen Repositori**: Git Version Control