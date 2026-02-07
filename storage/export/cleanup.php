<?php
/**
 * storage/export/cleanup.php
 * Hapus file export lama (> 1 hari)
 */

$baseDir = __DIR__;
$maxAge  = 60 * 60 * 24; // 1 hari

$folders = ['pdf', 'excel'];

foreach ($folders as $folder) {
    $path = $baseDir . '/' . $folder;

    foreach (glob($path . '/*') as $file) {
        if (is_file($file)) {
            if (time() - filemtime($file) > $maxAge) {
                unlink($file);
            }
        }
    }
}
