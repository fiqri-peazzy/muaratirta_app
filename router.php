<?php

/**
 * Router untuk `php -S localhost:PORT router.php`.
 * Meniru aturan rewrite di .htaccess (yang hanya berlaku di Apache/LiteSpeed produksi)
 * supaya URL cantik seperti /login, /admin, /berita/slug-x juga jalan di dev server lokal.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = ltrim($uri, '/');
$fullPath = __DIR__ . '/' . $path;

// 1. Root path -> index.php
if ($path === '') {
    chdir(__DIR__);
    require __DIR__ . '/index.php';
    return true;
}

// 1b. Blokir file sensitif, samakan dengan aturan di .htaccess untuk production.
if (preg_match('#(^|/)(\.env.*|\.git.*|composer\.(json|lock)|error_log|\.htaccess|debug_.*\.json)$#', $path)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

// 2. File/folder yang memang ada (asset, admin/index.php, api/*.php, dst) -> biarkan
//    built-in server yang tangani apa adanya.
if (is_file($fullPath) || is_dir($fullPath)) {
    return false;
}

// 2. Pola /segment/slug -> segment.php?slug=slug (mis. /berita/nama-berita)
if (preg_match('#^([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)$#', $path, $m)) {
    $target = __DIR__ . '/' . $m[1] . '.php';
    if (is_file($target)) {
        $_GET['slug'] = $m[2];
        chdir(__DIR__);
        require $target;
        return true;
    }
}

// 3. Pola /segment -> segment.php (mis. /login, /berita, /admin)
if (preg_match('#^([a-zA-Z0-9-]+)$#', $path, $m)) {
    $target = __DIR__ . '/' . $m[1] . '.php';
    if (is_file($target)) {
        chdir(__DIR__);
        require $target;
        return true;
    }
}

// 4. Tidak ada yang cocok -> 404, sama seperti perilaku production.
http_response_code(404);
require __DIR__ . '/404.php';
return true;
