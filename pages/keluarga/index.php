<?php
/**
 * pages/keluarga/index.php
 * List data keluarga
 */

$title = "Data Keluarga";

// 1. Muat Konfigurasi & Database (WAJIB agar $conn tersedia)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. AWAL PERBAIKAN LAYOUT: Gunakan d-flex agar Sidebar & Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/KeluargaModel.php";

// Hak akses modul keluarga
authorize('keluarga');

$model    = new KeluargaModel();
$keluarga = $model->getAll();
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <h4 class="mb-4">🏠 Data Keluarga</h4>

        <div class="mb-3">
            <a href="create.php" class="btn btn-success shadow-sm">
                ➕ Tambah Keluarga
            </a>
        </div>

        <div class="table-responsive bg-white shadow-sm p-3 rounded">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode/No. KK Gereja</th>
                        <th>Kepala Keluarga</th>
                        <th>Wilayah</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($keluarga)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-3 text-muted">
                            Data keluarga belum tersedia
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($keluarga as $k): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($k['no_kk_gereja'] ?? '-'); ?></td>
                        <td><?= htmlspecialchars($k['kepala_keluarga'] ?? '-'); ?></td>
                        <td><?= htmlspecialchars($k['nama_wilayah'] ?? ($k['wilayah_id'] ?? '-')); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="edit.php?id=<?= $k['id']; ?>"
                                   class="btn btn-sm btn-warning">
                                   ✏️ Edit
                                </a>

                                <a href="delete.php?id=<?= $k['id']; ?>"
                                   onclick="return confirm('Yakin hapus data keluarga ini?')"
                                   class="btn btn-sm btn-danger">
                                   🗑 Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
echo '</div>'; // Penutup d-flex
require_once "../../layout/footer.php"; 
?>