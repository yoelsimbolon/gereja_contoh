<?php

// Mulai session dengan aman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// timezone
date_default_timezone_set("Asia/Jakarta");

// base url
define("BASE_URL", "http://localhost/gereja-app/");
