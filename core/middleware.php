<?php
/**
 * core/middleware.php
 */


/**
 * Cek apakah user sudah login
 */
function require_login()
{
    if (!isset($_SESSION['user'])) {

        header("Location: /gereja-app/auth/login.php");
        exit;
    }
}

/**
 * Alias untuk semua user login
 * (dipakai di header.php)
 */
function allUser()
{
    require_login();
}

/**
 * Ambil data user login
 */
function user()
{
    return $_SESSION['user'] ?? null;
}

/**
 * Cek role user
 */
function has_role($role)
{
    if (!isset($_SESSION['user'])) return false;

    return $_SESSION['user']['role'] === $role;
}

