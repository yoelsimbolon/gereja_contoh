<?php
/**
 * pages/keluarga/store.php
 * Proses simpan data keluarga
 */

// 1. Muat koneksi database agar global $conn tersedia
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

// 2. Ambil & sanitasi input (Gunakan no_kk_gereja sesuai database)
$data = [
    'no_kk_gereja'    => trim($_POST['no_kk_gereja'] ?? ''),
    'kepala_keluarga' => trim($_POST['kepala_keluarga'] ?? ''), // Pastikan ini 'kepala_keluarga'
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
    header("Location: create.php");
    exit;
}

$model = new KeluargaModel();

// 4. Gunakan metode insert() sesuai yang ada di KeluargaModel
$result = $model->insert($data);

if ($result) {
    // Catat log aktivitas jika fungsi tersedia
    if (function_exists('log_activity')) {
        log_activity(
            $_SESSION['user']['id'],
            'CREATE',
            'Menambahkan keluarga: ' . $data['no_kk_gereja']
        );
    }

    if (function_exists('set_flash')) {
        set_flash('success', 'Data keluarga berhasil disimpan');
    }
    header("Location: index.php");
    exit;
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal menyimpan data keluarga');
    }
    header("Location: create.php");
    exit;
}