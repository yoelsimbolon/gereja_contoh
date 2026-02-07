<?php
/**
 * layout/sidebar.php
 */

require_once __DIR__ . "/../core/helper.php";
require_once __DIR__ . "/../core/role.php";

$user = user();
?>

<!-- Sidebar -->
<div class="sidebar bg-dark text-white p-4" style="width:250px; min-height:100vh;">
    <h5 class="mb-3">⛪ Sistem Gereja</h5>

    <div class="mb-4">
        <strong><?= htmlspecialchars($user['nama'] ?? 'User', ENT_QUOTES, 'UTF-8'); ?></strong><br>
        <small><?= htmlspecialchars(ucfirst($user['role'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></small>
    </div>

    <ul class="nav flex-column">

        <?php if (can('dashboard')): ?>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= url('pages/dashboard.php'); ?>">
                🏠 Dashboard
            </a>
        </li>
        <?php endif; ?>

        <?php if (can('jemaat')): ?>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= url('pages/jemaat/index.php'); ?>">
                👥 Data Jemaat
            </a>
        </li>
        <?php endif; ?>

        <?php if (can('keluarga')): ?>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= url('pages/keluarga/index.php'); ?>">
                🏡 Data Keluarga
            </a>
        </li>
        <?php endif; ?>

        <?php if (can('laporan')): ?>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= url('pages/laporan/index.php'); ?>">
                📊 Laporan
            </a>
        </li>
        <?php endif; ?>

        <?php if (can('pengaturan')): ?>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?= url('pages/pengaturan/index.php'); ?>">
                ⚙️ Pengaturan
            </a>
        </li>
        <?php endif; ?>

        <hr class="text-secondary">

        <li class="nav-item">
            <a class="nav-link text-danger" href="<?= url('auth/logout.php'); ?>">
                🚪 Keluar
            </a>
        </li>

    </ul>
</div>

<!-- Konten utama -->
<div class="content p-4" style="flex:1;">
