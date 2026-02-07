<?php
require_once "../../core/middleware.php";
require_once "../../config/database.php";

require_login();
authorize('admin');

$stmt = $pdo->prepare("UPDATE gereja SET nama=?, alamat=?, telepon=?");
$stmt->execute([
    $_POST['nama'],
    $_POST['alamat'],
    $_POST['telepon']
]);

set_flash('success', 'Profil gereja diperbarui');
redirect('gereja.php');
