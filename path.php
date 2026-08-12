<?php

define("ROOT_PATH", realpath(dirname(__FILE__)));

require_once ROOT_PATH . '/vendor/autoload.php';
if (file_exists(ROOT_PATH . '/.env') && !isset($_ENV['EMAIL_HOST'])) {
    \Dotenv\Dotenv::createImmutable(ROOT_PATH)->load();
}

// Production URL
define("BASE_URL", "https://muaratirta.co.id");

// Development URL
// define("BASE_URL", "http://localhost/muaratirta_app");