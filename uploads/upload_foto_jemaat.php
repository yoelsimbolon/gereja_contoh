<?php
require_once "../../core/middleware.php";
require_once "../../core/helper.php";

require_login();

if (!isset($_FILES['foto'])) {
    set_flash('error', 'File tidak ditemukan');
    redirect_back();
}

$file = $_FILES['foto'];

$allowed = ['image/jpeg', 'image/png'];
$maxSize = 2 * 1024 * 1024; // 2MB

if (!in_array($file['type'], $allowed)) {
    set_flash('error', 'Format harus JPG atau PNG');
    redirect_back();
}

if ($file['size'] > $maxSize) {
    set_flash('error', 'Ukuran maksimal 2MB');
    redirect_back();
}

// Nama aman
$ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
$name = 'jemaat_' . time() . '_' . rand(100,999) . '.' . $ext;

$dest = "../../storage/uploads/jemaat/" . $name;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    set_flash('error', 'Upload gagal');
    redirect_back();
}

// Simpan nama file ke database di store/update jemaat
$_SESSION['uploaded_foto'] = $name;

set_flash('success', 'Foto berhasil diupload');
redirect_back();
