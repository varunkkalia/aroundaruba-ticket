<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\Admin;

final class Auth
{
    public static function attempt(string $username, string $password): bool
    {
        $adminModel = new Admin();
        $admin = $adminModel->findByUsername($username);

        if (!$admin || !password_verify($password, $admin['password'])) {
            return false;
        }

        Session::regenerate();
        Session::put('admin_id', (int) $admin['id']);
        Session::put('admin_username', $admin['username']);

        return true;
    }

    public static function check(): bool
    {
        return Session::get('admin_id') !== null;
    }

    public static function ensureAuthenticated(): void
    {
        if (!self::check()) {
            Session::flash('error', 'Please log in to continue.');
            header('Location: index.php?route=login');
            exit;
        }
    }

    public static function logout(): void
    {
        Session::remove('admin_id');
        Session::remove('admin_username');
        Session::regenerate();
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => Session::get('admin_id'),
            'username' => Session::get('admin_username'),
        ];
    }
}

