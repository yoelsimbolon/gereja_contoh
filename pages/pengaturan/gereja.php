<?php
require_once "../../core/middleware.php";
require_once "../../config/database.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

require_login();
authorize('admin');

$data = $pdo->query("SELECT * FROM gereja LIMIT 1")->fetch();
?>

<div class="container">
    <h3>Profil Gereja</h3>

    <form action="gereja_update.php" method="post">
        <div class="mb-2">
            <label>Nama Gereja</label>
            <input type="text" name="nama" value="<?= $data['nama']; ?>" class="form-control">
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= $data['alamat']; ?></textarea>
        </div>

        <div class="mb-2">
            <label>Telepon</label>
            <input type="text" name="telepon" value="<?= $data['telepon']; ?>" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

<?php require_once "../../layout/footer.php"; ?>
