<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Admin extends Model
{
    public function findByUsername(string $username): ?array
    {
        $statement = $this->db()->prepare('SELECT * FROM admins WHERE username = :username LIMIT 1');
        $statement->execute(['username' => $username]);
        $admin = $statement->fetch();

        return $admin ?: null;
    }

    public function count(): int
    {
        return (int) $this->db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
    }

    public function create(string $username, string $password): void
    {
        $statement = $this->db()->prepare(
            'INSERT INTO admins (username, password, created_at, updated_at) VALUES (:username, :password, NOW(), NOW())'
        );

        $statement->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
}
