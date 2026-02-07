<?php
/**
 * core/role.php
 * Manajemen role & permission
 */

require_once __DIR__ . "/helper.php";

/* ===========================
   DEFINISI PERMISSION
=========================== */

/**
 * Daftar permission tiap role
 */
function rolePermissions()
{
    return [
        'admin' => [
            'dashboard',
            'jemaat',
            'keluarga',
            'laporan',
            'pengaturan',
            'user'
        ],
        'petugas' => [
            'dashboard',
            'jemaat',
            'keluarga',
            'laporan'
        ],
        'pendeta' => [
            'dashboard',
            'laporan'
        ],
    ];
}

/* ===========================
   CEK PERMISSION
=========================== */

/**
 * Cek apakah role user punya akses ke fitur
 */
function can($permission)
{
    if (!isLogin()) return false;

    $role = user()['role'];
    $permissions = rolePermissions();

    return isset($permissions[$role]) &&
           in_array($permission, $permissions[$role]);
}

/**
 * Paksa izin akses (dipakai di halaman)
 */
function authorize($permission)
{
    if (!can($permission)) {
        die("Akses ditolak: tidak memiliki izin");
    }
}
