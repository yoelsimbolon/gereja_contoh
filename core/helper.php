<?php
/**
 * core/helper.php
 * Kumpulan fungsi bantuan global
 */

require_once __DIR__ . '/../config/config.php';

/* ===========================
   URL & REDIRECT
=========================== */

function url($path = '')
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function redirect($path)
{
    header("Location: " . url($path));
    exit;
}

/* ===========================
   KEAMANAN & INPUT
=========================== */

function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function post($key)
{
    return $_POST[$key] ?? null;
}

function get($key)
{
    return $_GET[$key] ?? null;
}

/* ===========================
   FORMAT DATA
=========================== */

function formatTanggal($date)
{
    if (!$date) return '-';
    return date("d-m-Y", strtotime($date));
}

function generateNoJemaat($id)
{
    return "JMT-" . date("Y") . "-" . str_pad($id, 4, "0", STR_PAD_LEFT);
}
if (!function_exists('user')) {
    function user()
    {
        return $_SESSION['user'] ?? null;
    }
}
function isLogin()
{
    return isset($_SESSION['user']);
}
function set_flash($type, $message) {
    if(!isset($_SESSION)) { session_start(); }
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}