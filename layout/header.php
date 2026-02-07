<?php
/**
 * layout/header.php
 */

require_once __DIR__ . "/../core/middleware.php";
require_once __DIR__ . "/../core/helper.php";

// Proteksi: semua halaman yang pakai header HARUS login
allUser();

// Judul halaman (opsional)
$title = $title ?? 'Sistem Informasi Gereja';
$user  = user();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>

    <!-- CSS Global -->
    <link rel="stylesheet" href="<?= url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= url('assets/css/style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon (opsional) -->
    <link rel="icon" href="<?= url('assets/img/logo.png'); ?>">
</head>
<body>

<!-- Wrapper utama -->
<div class="wrapper">
