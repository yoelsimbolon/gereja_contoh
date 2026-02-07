<?php
/**
 * pages/keluarga/update.php
 * Proses update data keluarga
 */

// 1. Muat koneksi database agar global $conn tersedia untuk model
require_once "../../config/config.php";
require_once "../../config/database.php"; 
require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/KeluargaModel.php";

// Pastikan user login
require_login();

// Hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// Ambil ID
$id = $_POST['id'] ?? null;

if (!$id) {
    if (function_exists('set_flash')) {
        set_flash('error', 'ID keluarga tidak ditemukan');
    }
    header("Location: index.php");
    exit;
}

// 2. Ambil & sanitasi input (Sesuaikan nama key dengan struktur tabel)
$data = [
    'no_kk_gereja'    => trim($_POST['no_kk_gereja'] ?? ''),
    'kepala_keluarga' => trim($_POST['kepala_keluarga'] ?? ''),
    'wilayah_id'      => $_POST['wilayah_id'] ?? null,
    'alamat'          => trim($_POST['alamat'] ?? '')
];

// 3. Validasi wajib
if (
    $data['no_kk_gereja'] === '' ||
    $data['kepala_keluarga'] === '' ||
    !$data['wilayah_id']
) {
    if (function_exists('set_flash')) {
        set_flash('error', 'Semua field wajib diisi');
    }
    header("Location: edit.php?id=$id");
    exit;
}

$model = new KeluargaModel();

// 4. Update data menggunakan method update yang selaras dengan MySQLi
$result = $model->update($id, $data);

if ($result) {
    // Catat log aktivitas jika fungsi tersedia
    if (function_exists('log_activity')) {
        log_activity(
            $_SESSION['user']['id'],
            'UPDATE',
            'Memperbarui data keluarga ID: ' . $id
        );
    }

    if (function_exists('set_flash')) {
        set_flash('success', 'Data keluarga berhasil diperbarui');
    }
    header("Location: index.php");
    exit;
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal memperbarui data keluarga');
    }
    header("Location: edit.php?id=$id");
    exit;
}