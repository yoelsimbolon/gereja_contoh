<?php
/**
 * pages/jemaat/update.php
 * Proses update data jemaat
 */

// 1. Muat koneksi database dan config agar global $conn tersedia
require_once "../../config/config.php";
require_once "../../config/database.php"; 
require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";

// Pastikan user login
require_login();

// Hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Gunakan header jika fungsi redirect() Anda belum mendukung path dinamis
    header("Location: index.php");
    exit;
}

// Ambil ID jemaat
$id = $_POST['id'] ?? null;

if (!$id) {
    if (function_exists('set_flash')) {
        set_flash('error', 'ID jemaat tidak ditemukan');
    }
    header("Location: index.php");
    exit;
}

// 2. Ambil & sanitasi input (Sesuaikan nama key dengan yang ada di form edit.php)
$data = [
    'nama_lengkap'      => trim($_POST['nama_lengkap'] ?? ''), 
    'jenis_kelamin'     => $_POST['jenis_kelamin'] ?? '',
    'tempat_lahir'      => trim($_POST['tempat_lahir'] ?? ''),
    'tanggal_lahir'     => $_POST['tanggal_lahir'] ?: null,
    'no_hp'             => trim($_POST['no_hp'] ?? ''),
    'keluarga_id'       => $_POST['keluarga_id'] ?: null,
    'status_pernikahan' => $_POST['status_pernikahan'] ?? ''
];

// 3. Validasi wajib (Gunakan nama_lengkap)
if ($data['nama_lengkap'] === '' || $data['jenis_kelamin'] === '') {
    if (function_exists('set_flash')) {
        set_flash('error', 'Nama dan jenis kelamin wajib diisi');
    }
    header("Location: edit.php?id=$id");
    exit;
}

$model = new JemaatModel();

// 4. Update data menggunakan method update yang sudah kita buat di JemaatModel
$result = $model->update($id, $data);

if ($result) {
    // Catat log aktivitas jika fungsi tersedia
    if (function_exists('log_activity')) {
        log_activity(
            $_SESSION['user']['id'],
            'UPDATE',
            'Memperbarui data jemaat ID: ' . $id
        );
    }

    if (function_exists('set_flash')) {
        set_flash('success', 'Data jemaat berhasil diperbarui');
    }
    header("Location: index.php");
    exit;
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal memperbarui data jemaat');
    }
    header("Location: edit.php?id=$id");
    exit;
}