<?php
/**
 * auth/process_login.php
 * Proses login user
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/helper.php';

// echo '<pre>';
// var_dump($_POST);
// exit;
// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('auth/login.php');
}

// Ambil input
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Debug (aktifkan hanya jika perlu)
/*
echo '<pre>';
var_dump($_POST);
exit;
*/

// Validasi kosong
if ($email === '' || $password === '') {
    redirect('auth/login.php?error=1');
}

// Cari user
$stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verifikasi user dan password
if ($user && password_verify($password, $user['password'])) {

    // Amankan session
    session_regenerate_id(true);

    // Simpan session
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nama' => $user['nama'],
        'email' => $user['email'],
        'role' => $user['role']
    ];

    // Redirect dashboard
    redirect('pages/dashboard.php');
}

// Jika gagal login
redirect('auth/login.php?error=1');
