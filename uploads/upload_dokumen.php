<?php
require_once "../../core/middleware.php";
require_once "../../core/helper.php";

require_login();

$file = $_FILES['dokumen'];

$allowed = [
    'application/pdf',
    'image/jpeg',
    'image/png'
];

if (!in_array($file['type'], $allowed)) {
    set_flash('error','Dokumen tidak didukung');
    redirect_back();
}

$ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
$name = 'doc_' . time() . '.' . $ext;

move_uploaded_file(
    $file['tmp_name'],
    "../../storage/uploads/dokumen/$name"
);

$_SESSION['uploaded_dokumen'] = $name;
redirect_back();
