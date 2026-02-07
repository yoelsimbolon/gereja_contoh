<?php
/**
 * pages/jemaat/create.php
 * Form tambah jemaat
 */

$title = "Tambah Jemaat";

// 1. Muat Database agar koneksi $conn tersedia untuk Model
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. Gunakan d-flex agar Sidebar dan Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";

// Hak akses
authorize('jemaat');

// Ambil data keluarga & wilayah untuk dropdown
$keluargaModel = new KeluargaModel();
$wilayahModel  = new WilayahModel();

$listKeluarga = $keluargaModel->getAll();
$listWilayah  = $wilayahModel->getAll();
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <div class="card shadow-sm p-4">
            <h4 class="mb-4">➕ Tambah Data Jemaat</h4>

            <form action="store.php" method="POST">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status Pernikahan</label>
                        <select name="status_pernikahan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Janda/Duda">Janda / Duda</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Keluarga</label>
                        <select name="keluarga_id" class="form-control">
                            <option value="">-- Pilih Keluarga --</option>
                            <?php foreach ($listKeluarga as $k): ?>
                                <option value="<?= $k['id']; ?>">
                                    <?= htmlspecialchars($k['nama_kepala_keluarga']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Wilayah</label>
                        <select name="wilayah_id" class="form-control">
                            <option value="">-- Pilih Wilayah --</option>
                            <?php foreach ($listWilayah as $w): ?>
                                <option value="<?= $w['id']; ?>">
                                    <?= htmlspecialchars($w['nama_wilayah']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Data
                    </button>
                    <a href="index.php" class="btn btn-secondary">
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