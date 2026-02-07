<?php
require_once "../../core/middleware.php";
require_once "../../models/UserModel.php";
require_once "../../layout/header.php";
require_once "../../layout/sidebar.php";

require_login();
authorize('admin');

$model = new UserModel();
$users = $model->getAll();
?>

<div class="container">
    <h3>Manajemen User</h3>
    <a href="user_create.php" class="btn btn-primary btn-sm">Tambah User</a>

    <table class="table mt-3">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['nama']; ?></td>
            <td><?= $u['email']; ?></td>
            <td><?= $u['role']; ?></td>
            <td>
                <a href="user_edit.php?id=<?= $u['id']; ?>">Edit</a> |
                <a href="user_delete.php?id=<?= $u['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once "../../layout/footer.php"; ?>
