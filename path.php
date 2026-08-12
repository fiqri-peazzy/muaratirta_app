<?php

define("ROOT_PATH", realpath(dirname(__FILE__)));

// Catat semua error ke log, tapi jangan tampilkan notice/deprecated ke output
// (mencegah warning bocor ke response JSON/API dan merusak parsing di frontend)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once ROOT_PATH . '/vendor/autoload.php';
if (file_exists(ROOT_PATH . '/.env') && !isset($_ENV['EMAIL_HOST'])) {
    \Dotenv\Dotenv::createImmutable(ROOT_PATH)->load();
}

$app_env = $_ENV['APP_ENV'] ?? 'production';

if ($app_env === 'local' && !empty($_SERVER['HTTP_HOST'])) {
    // Ikuti host yang sedang diakses (localhost:8000, 127.0.0.1, dst) agar tidak perlu
    // ganti-ganti BASE_URL manual tiap kali port/URL dev berubah.
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    define("BASE_URL", $scheme . '://' . $_SERVER['HTTP_HOST']);
} else {
    define("BASE_URL", $_ENV['APP_URL'] ?? 'https://muaratirta.co.id');
}