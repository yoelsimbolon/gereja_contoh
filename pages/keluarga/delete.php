<?php
/**
 * pages/keluarga/delete.php
 * Proses hapus data keluarga
 */

// 1. MUAT DATABASE & CONFIG (WAJIB agar $conn tersedia)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/JemaatModel.php";

// Pastikan user login
require_login();

// Ambil ID
$id = $_GET['id'] ?? null;

if (!$id) {
    if (function_exists('set_flash')) {
        set_flash('error', 'ID keluarga tidak ditemukan');
    }
    header("Location: index.php");
    exit;
}

$keluargaModel = new KeluargaModel();
$jemaatModel   = new JemaatModel();

// 2. PROTEKSI: Cek apakah keluarga masih memiliki anggota jemaat
// Pastikan fungsi ini ada di JemaatModel, jika tidak gunakan query manual:
$sqlCheck = "SELECT COUNT(*) FROM jemaat WHERE keluarga_id = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("i", $id);
$stmt->execute();
$totalJemaat = $stmt->get_result()->fetch_row()[0];

if ($totalJemaat > 0) {
    if (function_exists('set_flash')) {
        set_flash(
            'error',
            'Keluarga tidak dapat dihapus karena masih memiliki anggota jemaat'
        );
    }
    header("Location: index.php");
    exit;
}

// 3. Eksekusi hapus data
$result = $keluargaModel->delete($id);

if ($result) {
    // Catat log aktivitas jika fungsi tersedia
    if (function_exists('log_activity')) {
        log_activity(
            $_SESSION['user']['id'],
            'DELETE',
            'Menghapus data keluarga ID: ' . $id
        );
    }

    if (function_exists('set_flash')) {
        set_flash('success', 'Data keluarga berhasil dihapus');
    }
} else {
    if (function_exists('set_flash')) {
        set_flash('error', 'Gagal menghapus data keluarga');
    }
}

header("Location: index.php");
exit;