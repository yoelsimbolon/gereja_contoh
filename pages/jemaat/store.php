<?php
/**
 * pages/jemaat/store.php
 * Proses simpan data jemaat
 */

require_once "../../config/config.php"; // Tambahkan ini
require_once "../../config/database.php"; // Wajib agar $conn tersedia
require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";

// Pastikan user login
require_login();

// Cegah akses langsung tanpa POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// Ambil & sanitasi input (SESUAIKAN DENGAN FORM CREATE)
$data = [
    // Gunakan 'nama_lengkap' sesuai kolom di database
    'nama_lengkap'      => trim($_POST['nama_lengkap'] ?? ''), 
    'jenis_kelamin'     => $_POST['jenis_kelamin'] ?? '',
    'tempat_lahir'      => trim($_POST['tempat_lahir'] ?? ''),
    'tanggal_lahir'     => $_POST['tanggal_lahir'] ?: null,
    'no_hp'             => trim($_POST['no_hp'] ?? ''),
    'keluarga_id'       => $_POST['keluarga_id'] ?: null,
    'status_pernikahan' => $_POST['status_pernikahan'] ?? ''
];

// Validasi wajib
if ($data['nama_lengkap'] === '' || $data['jenis_kelamin'] === '') {
    // Jika set_flash error, pastikan fungsi ini ada di helper.php
    if (function_exists('set_flash')) {
        set_flash('error', 'Nama dan jenis kelamin wajib diisi');
    }
    header("Location: create.php");
    exit;
}

$model = new JemaatModel();

// PERBAIKAN: Gunakan method 'insert' (sesuai yang ada di JemaatModel kamu)
$result = $model->insert($data);

if ($result) {
    // Catat log (jika fungsi ini ada)
    if (function_exists('log_activity')) {
        log_activity(
            $_SESSION['user']['id'],
            'CREATE',
            'Menambahkan jemaat: ' . $data['nama_lengkap']
        );
    }

    if (function_exists('set_flash')) {
        set_flash('success', 'Data jemaat berhasil disimpan');
    }
    header("Location: index.php");
    exit;
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal menyimpan data jemaat');
    }
    header("Location: create.php");
    exit;
}