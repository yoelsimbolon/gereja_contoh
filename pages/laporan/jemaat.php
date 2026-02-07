<?php
/**
 * pages/laporan/jemaat.php
 * Laporan data jemaat
 */

$title = "Laporan Jemaat";

// 1. Muat Konfigurasi & Database (WAJIB agar $conn tersedia)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. AWAL PERBAIKAN LAYOUT: Gunakan d-flex agar Sidebar & Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";
require_once "../../models/WilayahModel.php";

// Hak akses laporan
authorize('laporan');

// Ambil filter wilayah
$wilayah_id = $_GET['wilayah_id'] ?? null;

// Ambil data wilayah (untuk info filter)
$wilayahModel = new WilayahModel();
$wilayahNama  = 'Semua Wilayah';

if ($wilayah_id) {
    $w = $wilayahModel->getById($wilayah_id);
    if ($w) {
        // Perbaikan: Gunakan 'nama_wilayah' sesuai kolom DB
        $wilayahNama = $w['nama_wilayah'];
    }
}

// Ambil data jemaat
$jemaatModel = new JemaatModel();
$jemaat      = $jemaatModel->getReport($wilayah_id);
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <div class="card shadow-sm p-4">
            <h4 class="mb-2">📋 Laporan Jemaat</h4>
            <p class="text-muted">
                Wilayah: <strong><?= htmlspecialchars($wilayahNama); ?></strong>
            </p>

            <div class="mb-3">
                <a href="index.php" class="btn btn-secondary btn-sm shadow-sm">
                    ↩ Kembali
                </a>
            </div>

            <div class="table-responsive bg-white">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Kepala Keluarga</th>
                            <th>Wilayah</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (empty($jemaat)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-3">
                                Data jemaat tidak ditemukan
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($jemaat as $j): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($j['nama_lengkap'] ?? '-'); ?></td>
                            <td><?= ($j['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?= htmlspecialchars($j['tanggal_lahir'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($j['kepala_keluarga'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($j['nama_wilayah'] ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
echo '</div>'; // Penutup d-flex
require_once "../../layout/footer.php"; 
?>