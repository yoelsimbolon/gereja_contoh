<?php
require_once "../../core/middleware.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

require_login();
?>

<div class="container">
    <h3>Ganti Password</h3>

    <form action="password_update.php" method="post">
        <div class="mb-2">
            <label>Password Lama</label>
            <input type="password" name="old" class="form-control">
        </div>

        <div class="mb-2">
            <label>Password Baru</label>
            <input type="password" name="new" class="form-control">
        </div>

        <button class="btn btn-warning">Ubah Password</button>
    </form>
</div>

<?php require_once "../../layout/footer.php"; ?>
