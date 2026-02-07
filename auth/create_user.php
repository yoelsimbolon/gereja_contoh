<?php
require_once __DIR__ . '/../config/database.php';

$nama     = "Admin Gereja";
$email    = "admin@gereja.id";
$password = password_hash("password", PASSWORD_DEFAULT);
$role     = "admin";

// Cek apakah email sudah ada
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "Email sudah terdaftar. Gunakan email lain.";
    exit;
}

// Insert user
$stmt = $conn->prepare("
INSERT INTO users (nama, email, password, role)
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("ssss", $nama, $email, $password, $role);

if ($stmt->execute()) {
    echo "User berhasil dibuat";
} else {
    echo "Gagal: " . $stmt->error;
}
