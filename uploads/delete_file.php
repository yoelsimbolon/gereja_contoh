<?php
require_once "../../core/middleware.php";
require_once "../../core/helper.php";

require_login();

$file = $_GET['file'] ?? '';
$type = $_GET['type'] ?? '';

$base = "../../storage/uploads/";

$map = [
    'jemaat'   => 'jemaat/',
    'keluarga' => 'keluarga/',
    'dokumen'  => 'dokumen/'
];

if (!isset($map[$type])) {
    redirect_back();
}

$path = realpath($base . $map[$type] . $file);

if ($path && strpos($path, realpath($base)) === 0 && file_exists($path)) {
    unlink($path);
}

redirect_back();
