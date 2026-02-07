<?php
require_once "../../core/middleware.php";
require_once "../../config/database.php";

require_login();

$id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT password FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!password_verify($_POST['old'], $user['password'])) {
    set_flash('error', 'Password lama salah');
    redirect('password.php');
}

$new = password_hash($_POST['new'], PASSWORD_DEFAULT);

$pdo->prepare("UPDATE users SET password=? WHERE id=?")
    ->execute([$new, $id]);

set_flash('success', 'Password berhasil diubah');
redirect('password.php');
