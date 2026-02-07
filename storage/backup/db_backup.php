<?php
/**
 * storage/backup/db_backup.php
 * Backup database MySQL
 * ONLY called internally
 */

require_once __DIR__ . "/../../config/database.php";

// ================== KONFIGURASI ==================
$backupDir = __DIR__;
$dbName    = DB_NAME;
$dbUser    = DB_USER;
$dbPass    = DB_PASS;
$dbHost    = DB_HOST;

// ================== NAMA FILE ==================
$filename = "backup_{$dbName}_" . date("Ymd_His") . ".sql";
$filepath = $backupDir . "/" . $filename;

// ================== COMMAND ==================
$command = sprintf(
    'mysqldump -h%s -u%s %s %s > %s',
    escapeshellarg($dbHost),
    escapeshellarg($dbUser),
    $dbPass ? '-p' . escapeshellarg($dbPass) : '',
    escapeshellarg($dbName),
    escapeshellarg($filepath)
);

// ================== EKSEKUSI ==================
exec($command, $output, $result);

// ================== HASIL ==================
if ($result !== 0) {
    return [
        'status' => false,
        'message' => 'Backup gagal'
    ];
}

return [
    'status' => true,
    'file'   => $filename,
    'path'   => $filepath
];
