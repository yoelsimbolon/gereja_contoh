<?php
/**
 * pages/laporan/index.php
 * Menu & filter laporan
 */

$title = "Laporan";

// 1. Muat Konfigurasi & Database (WAJIB agar $conn tersedia untuk model)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. AWAL PERBAIKAN LAYOUT: Gunakan d-flex agar Sidebar & Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/WilayahModel.php";

// Hak akses laporan
authorize('laporan');

// Data wilayah untuk filter
$wilayahModel = new WilayahModel();
$wilayah      = $wilayahModel->getAll();
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <h4 class="mb-4">📊 Laporan Gereja</h4>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">👥 Laporan Jemaat</h5>
                        <p class="card-text text-muted">Daftar jemaat berdasarkan wilayah</p>

                        <form action="jemaat.php" method="GET">
                            <select name="wilayah_id" class="form-select mb-3">
                                <option value="">Semua Wilayah</option>
                                <?php foreach ($wilayah as $w): ?>
                                    <option value="<?= $w['id']; ?>">
                                        <?= htmlspecialchars($w['nama_wilayah']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                Lihat Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">🏠 Laporan Keluarga</h5>
                        <p class="card-text text-muted">Daftar keluarga per wilayah</p>

                        <form action="keluarga.php" method="GET">
                            <select name="wilayah_id" class="form-select mb-3">
                                <option value="">Semua Wilayah</option>
                                <?php foreach ($wilayah as $w): ?>
                                    <option value="<?= $w['id']; ?>">
                                        <?= htmlspecialchars($w['nama_wilayah']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                Lihat Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">📈 Statistik</h5>
                        <p class="card-text text-muted">Ringkasan data jemaat, keluarga, dan wilayah.</p>

                        <div class="mt-auto">
                            <a href="statistik.php" class="btn btn-success w-100 shadow-sm">
                                Lihat Statistik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
echo '</div>'; // Penutup d-flex
require_once "../../layout/footer.php"; 
?>