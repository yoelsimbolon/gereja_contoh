<?php
require_once "../../core/middleware.php";
require_once "../../core/helper.php";

require_login();

$file = $_FILES['foto'] ?? null;
if (!$file) redirect_back();

$allowed = ['image/jpeg','image/png'];

if (!in_array($file['type'], $allowed)) {
    set_flash('error','Format tidak valid');
    redirect_back();
}

$ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
$name = 'keluarga_' . time() . '.' . $ext;

move_uploaded_file(
    $file['tmp_name'],
    "../../storage/uploads/keluarga/$name"
);

$_SESSION['uploaded_foto_keluarga'] = $name;
redirect_back();
