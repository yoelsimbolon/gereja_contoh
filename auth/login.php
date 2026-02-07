<?php
/**
 * auth/login.php
 * Halaman login Sistem Informasi Gereja
 */

require_once __DIR__ . '/../config/config.php';

// Jika user sudah login → redirect ke dashboard
if (isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "/pages/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Gereja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .church-icon {
            background: var(--primary-gradient);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.4);
        }

        .login-title {
            color: #2d3436;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #636e72;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 2px solid #f1f3f5;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #8f94fb;
            box-shadow: none;
            background-color: #fff;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            color: white;
            font-weight: 600;
            margin-top: 1rem;
            transition: transform 0.2s ease;
        }

        .btn-login:hover {
            transform: scale(1.02);
            color: white;
            opacity: 0.9;
        }

        .footer-text {
            font-size: 0.75rem;
            color: #b2bec3;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="login-card mx-3">
    <div class="text-center">
        <div class="church-icon">⛪</div>
        <h1 class="login-title">SIG GEREJA</h1>
        <p class="text-muted small mb-4">Sistem Informasi Manajemen Data Jemaat</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger py-2 small text-center rounded-3">
            Email atau Password tidak cocok.
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/process_login.php">
        <div class="mb-3">
            <label class="form-label">EMAIL</label>
            <input type="email" name="email" class="form-control" placeholder="admin@gereja.com" required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label">PASSWORD</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-login">MASUK SISTEM</button>
        </div>
    </form>

    <div class="text-center footer-text">
        &copy; <?= date('Y') ?> Gereja App Support Team
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>