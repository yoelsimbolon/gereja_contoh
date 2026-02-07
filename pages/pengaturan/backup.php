<?php
require_once "../../core/middleware.php";

require_login();
authorize('admin');

$result = require "../../storage/backup/db_backup.php";

if (!$result['status']) {
    set_flash('error', 'Backup database gagal');
    redirect('index.php');
}

// Download otomatis
header("Content-Type: application/sql");
header("Content-Disposition: attachment; filename=" . basename($result['file']));
readfile($result['path']);
exit;
