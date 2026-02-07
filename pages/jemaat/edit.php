<?php
/**
 * pages/jemaat/edit.php
 * Form edit data jemaat
 */

$title = "Edit Jemaat";

// 1. Muat Konfigurasi & Database
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// 2. Gunakan d-flex agar Sidebar dan Konten berdampingan
echo '<div class="d-flex">';

require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";

// Hak akses
authorize('jemaat');

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$jemaatModel   = new JemaatModel();
$keluargaModel = new KeluargaModel();
$wilayahModel  = new WilayahModel();

$jemaat = $jemaatModel->getById($id);

// Jika data tidak ditemukan
if (!$jemaat) {
    header("Location: index.php");
    exit;
}

// Data dropdown
$listKeluarga = $keluargaModel->getAll();
$listWilayah  = $wilayahModel->getAll();
?>

<div class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
    <div class="container-fluid">
        <div class="card shadow-sm p-4">
            <h4 class="mb-4">✏️ Edit Data Jemaat</h4>

            <form action="update.php" method="POST">

                <input type="hidden" name="id" value="<?= $jemaat['id']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                               value="<?= htmlspecialchars($jemaat['nama_lengkap']); ?>" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="L" <?= $jemaat['jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option>
                            <option value="P" <?= $jemaat['jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
    <label class="form-label">Status Pernikahan</label>
    <select name="status_pernikahan" class="form-control" required>
        <?php
        $statusList = ['Belum Menikah', 'Menikah', 'Janda/Duda'];
        foreach ($statusList as $s):
        ?>
            <option value="<?= $s; ?>"
                <?= (isset($jemaat['status']) && $jemaat['status'] == $s) ? 'selected' : ''; ?>>
                <?= $s; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                               value="<?= htmlspecialchars($jemaat['tempat_lahir'] ?? ''); ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                               value="<?= $jemaat['tanggal_lahir']; ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control"
                               value="<?= htmlspecialchars($jemaat['no_hp'] ?? ''); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= 
                        htmlspecialchars($jemaat['alamat'] ?? ''); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Keluarga</label>
                        <select name="keluarga_id" class="form-control">
                            <option value="">-- Pilih Keluarga --</option>
                            <?php foreach ($listKeluarga as $k): ?>
                                <option value="<?= $k['id']; ?>"
                                    <?= $jemaat['keluarga_id']==$k['id']?'selected':''; ?>>
                                    <?= htmlspecialchars($k['kepala_keluarga']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Wilayah</label>
                        <select name="wilayah_id" class="form-control">
                            <option value="">-- Pilih Wilayah --</option>
                            <?php foreach ($listWilayah as $w): ?>
                                <option value="<?= $w['id']; ?>"
                                    <?= ($jemaat['wilayah_id'] ?? '') == $w['id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($w['nama_wilayah']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        💾 Update Data
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        ↩ Batal
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