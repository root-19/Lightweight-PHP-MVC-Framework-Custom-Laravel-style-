<?php


if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $file = __DIR__ . '/public' . $url;
    if (is_file($file)) {
        return false;
    }
}

require_once realpath(__DIR__ . '/public/index.php');

