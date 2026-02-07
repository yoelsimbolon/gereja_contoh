<?php
/**
 * pages/keluarga/edit.php
 * Form edit data keluarga
 */

$title = "Edit Keluarga";

// 1. Muat Konfigurasi & Database (WAJIB agar $conn tersedia untuk model)
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. AWAL PERBAIKAN LAYOUT: Gunakan d-flex agar Sidebar & Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";

// Hak akses
authorize('keluarga');

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
$data = $keluargaModel->getById($id);

if (!$data) {
    if (function_exists('set_flash')) {
        set_flash('error', 'Data keluarga tidak ditemukan');
    }
    header("Location: index.php");
    exit;
}

// Data wilayah
$wilayahModel = new WilayahModel();
$wilayah      = $wilayahModel->getAll();
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <div class="card shadow-sm p-4">
            <h4 class="mb-4">✏️ Edit Data Keluarga</h4>

            <form action="update.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. KK Gereja</label>
                        <input type="text"
                               name="no_kk_gereja"
                               class="form-control"
                               value="<?= htmlspecialchars($data['no_kk_gereja'] ?? ''); ?>"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kepala Keluarga</label>
                        <input type="text"
                               name="kepala_keluarga"
                               class="form-control"
                               value="<?= htmlspecialchars($data['kepala_keluarga'] ?? ''); ?>"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Wilayah</label>
                        <select name="wilayah_id" class="form-select" required>
                            <option value="">-- Pilih Wilayah --</option>
                            <?php foreach ($wilayah as $w): ?>
                                <option value="<?= $w['id']; ?>"
                                    <?= $w['id'] == ($data['wilayah_id'] ?? '') ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($w['nama_wilayah']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat"
                                  class="form-control"
                                  rows="3"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        💾 Update Data
                    </button>
                    <a href="index.php" class="btn btn-secondary shadow-sm">
                        ↩ Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
echo '</div>'; // Penutup d-flex
require_once "../../layout/footer.php"; 
?>