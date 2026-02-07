<?php
/**
 * index.php
 * Entry point aplikasi Gereja App
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/helper.php';
require_once __DIR__ . '/core/auth.php'; 

// Mulai session (jika belum)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login → dashboard
if (is_logged_in()) {
    redirect('pages/dashboard.php');
}

// Jika belum login → login page
redirect('auth/login.php');
