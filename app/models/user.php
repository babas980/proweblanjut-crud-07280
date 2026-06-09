<?php
// app/models/User.php

function cekUsernameSama($conn, $username) {
    $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_stmt->execute([$username]);
    return $check_stmt->fetch();
}

function daftarkanUserBaru($conn, $username, $password) {
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $password]);
}

function getUserByUsername($conn, $username) {
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updatePasswordUser($conn, $username, $passwordBaru) {
    $sql = "UPDATE users SET password = :password WHERE username = :username";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        ':password' => $passwordBaru,
        ':username' => $username
    ]);
}
?>