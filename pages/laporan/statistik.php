<?php
/**
 * pages/laporan/statistik.php
 * Statistik ringkas data gereja
 */

$title = "Statistik Gereja";

// 1. Muat Konfigurasi & Database (WAJIB agar $conn tersedia untuk model)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. AWAL PERBAIKAN LAYOUT: Gunakan d-flex agar Sidebar & Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";

// Hak akses
authorize('laporan');

$jemaatModel   = new JemaatModel();
$keluargaModel = new KeluargaModel();
$wilayahModel  = new WilayahModel();

// Statistik dasar
$totalJemaat   = $jemaatModel->countAll();
$totalKeluarga = $keluargaModel->countAll();
$totalWilayah  = $wilayahModel->countAll();

// Statistik tambahan
$jemaatLaki    = $jemaatModel->countByGender('L');
$jemaatPerem   = $jemaatModel->countByGender('P');
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <h4 class="mb-4">📈 Statistik Gereja</h4>

        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary shadow h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5>Total Jemaat</h5>
                        <h2 class="display-4 font-weight-bold"><?= $totalJemaat; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success shadow h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5>Total Keluarga</h5>
                        <h2 class="display-4 font-weight-bold"><?= $totalKeluarga; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning shadow h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5>Total Wilayah</h5>
                        <h2 class="display-4 font-weight-bold text-dark"><?= $totalWilayah; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-white bg-dark shadow h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5>Jenis Kelamin</h5>
                        <div class="text-left mx-auto">
                            <p class="mb-1 h5">👨 Laki-laki: <strong><?= $jemaatLaki; ?></strong></p>
                            <p class="mb-0 h5">👩 Perempuan: <strong><?= $jemaatPerem; ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary shadow-sm">
                ↩ Kembali ke Laporan
            </a>
        </div>
    </div>
</div>

<?php 
echo '</div>'; // Penutup d-flex
require_once "../../layout/footer.php"; 
?>