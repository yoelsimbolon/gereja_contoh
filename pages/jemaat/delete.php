<?php
/**
 * pages/jemaat/delete.php
 * Proses hapus data jemaat
 */

// 1. MUAT FILE DATABASE & CONFIG (WAJIB)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../core/middleware.php";
require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../core/logger.php";
require_once "../../models/JemaatModel.php";

// Wajib login
// Pastikan fungsi ini ada, atau gunakan require_login() jika sesuai middleware
require_login(); 

// Hak akses
authorize('jemaat');

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$model = new JemaatModel();
// Ambil data jemaat untuk keperluan log sebelum dihapus
$jemaat = $model->getById($id);

// Jika data tidak ditemukan
if (!$jemaat) {
    header("Location: index.php");
    exit;
}

// Hapus data
if ($model->delete($id)) {
    // Catat log aktivitas jika data berhasil dihapus
    if (function_exists('activityLog')) {
        activityLog(
            'HAPUS JEMAAT',
            'ID: ' . $id . ' | Nama: ' . ($jemaat['nama_lengkap'] ?? 'Tanpa Nama')
        );
    }
    
    if (function_exists('set_flash')) {
        set_flash('success', 'Data jemaat berhasil dihapus');
    }
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal menghapus data jemaat');
    }
}

// Kembali ke list
header("Location: index.php");
exit;