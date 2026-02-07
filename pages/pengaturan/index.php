<?php
require_once "../../core/middleware.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

require_login();
authorize('admin');
?>

<div class="container">
    <h3>Pengaturan Sistem</h3>

    <div class="list-group mt-3">
        <a href="gereja.php" class="list-group-item">Profil Gereja</a>
        <a href="user.php" class="list-group-item">Manajemen User</a>
        <a href="password.php" class="list-group-item">Ganti Password</a>
        <a href="backup.php" class="list-group-item">Backup Database</a>
    </div>
</div>

<?php require_once "../../layout/footer.php"; ?>
