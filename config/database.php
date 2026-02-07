<?php
/**
 * config/database.php
 * Koneksi database Gereja App
 */

require_once __DIR__ . '/config.php';

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_gereja";

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set charset (PENTING untuk keamanan & karakter Indonesia)


