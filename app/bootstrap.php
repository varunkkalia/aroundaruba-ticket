<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});

$config = require BASE_PATH . '/config/config.php';

date_default_timezone_set($config['app']['timezone'] ?? 'UTC');

\App\Core\App::setConfig($config);
\App\Core\Session::start();

function app_config(string $key, mixed $default = null): mixed
{
    return \App\Core\App::config($key, $default);
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
