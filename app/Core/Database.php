<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $host = App::config('database.host');
        $port = App::config('database.port', 3306);
        $database = App::config('database.name');
        $charset = App::config('database.charset', 'utf8mb4');
        $username = App::config('database.username');
        $password = App::config('database.password');

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $database, $charset);

        try {
            self::$connection = new PDO($dsn, (string) $username, (string) $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            http_response_code(500);
            echo 'Database connection failed. Please verify your configuration.';
            exit;
        }

        return self::$connection;
    }
}
