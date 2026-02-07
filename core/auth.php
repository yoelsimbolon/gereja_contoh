<?php

function is_logged_in()
{
    return isset($_SESSION['user']);
}

function current_user()
{
    return $_SESSION['user'] ?? null;
}

function has_role($role)
{
    return is_logged_in() && $_SESSION['user']['role'] === $role;
}

function require_login()
{
    if (!is_logged_in()) {
        redirect('auth/login.php');
    }
}

function require_role($role)
{
    if (!has_role($role)) {
        redirect('pages/dashboard.php');
    }
}
