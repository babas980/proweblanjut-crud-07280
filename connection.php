 <?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "inventory_pwl";

  $connection = mysqli_connect($host,$user,$pass,$db);

  if(!$connection){
    die("koneksi ke database gagal" . mysqli_connect_error());
  }

  function secure($data) {
    global $koneksi;
    // Menghapus spasi di awal dan akhir
    $data = trim($data);
    // Menghapus backslashes
    $data = stripslashes($data);
    // Mengubah karakter khusus menjadi entitas HTML (mencegah XSS)
    $data = htmlspecialchars($data);
    // Menghindari karakter aneh untuk SQL Injection
    $data = mysqli_real_escape_string($koneksi, $data);
    return $data;
}
?>