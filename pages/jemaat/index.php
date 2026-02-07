<?php
/**
 * pages/jemaat/index.php
 */
$title = "Data Jemaat";

// TAMBAHKAN INI: Agar koneksi $conn tersedia
require_once "../../config/config.php";
require_once "../../config/database.php"; 

require_once "../../layout/header.php";

// AWAL PERBAIKAN TAMPILAN: Gunakan d-flex agar sejajar ke samping
echo '<div class="d-flex">';
require_once "../../layout/sidebar.php";

require_once "../../core/role.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";

authorize('jemaat');

$model  = new JemaatModel();
$jemaat = $model->getAll();
?>

<div class="flex-grow-1 p-4">
    <h4 class="mb-4">👥 Data Jemaat</h4>

    <div class="mb-3">
        <a href="create.php" class="btn btn-success">
            ➕ Tambah Jemaat
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($jemaat)): ?>
                <tr>
                    <td colspan="6" class="text-center">Data jemaat belum tersedia</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($jemaat as $j): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($j['nama_lengkap']); ?></td>
                    <td><?= $j['jenis_kelamin']=='L'?'Laki-laki':'Perempuan'; ?></td>
                    <td><?= htmlspecialchars($j['no_hp']); ?></td>
                    <td><?= htmlspecialchars($j['status'] ?? '-'); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $j['id']; ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                        <a href="delete.php?id=<?= $j['id']; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">🗑 Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div> <?php require_once "../../layout/footer.php"; ?>