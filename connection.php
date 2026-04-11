<?php
try {
    $host     = "192.168.100.218";
    $dbname   = "inventory_pwl";   
    $username = "admin_web";     
    $password = "12345678";           

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Koneksi Gagal: " . $e->getMessage());
}

function secure($data) {
    //keamanan dengan menghapus spasi di awal dan akhir, backslashes, dan mecegah xss
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}
?>