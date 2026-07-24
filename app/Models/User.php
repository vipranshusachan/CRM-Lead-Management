<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User
{
    public static function find(int $id): ?array
    {
        return Database::fetch("SELECT id, name, email, role, created_at, updated_at FROM users WHERE id = ?", [$id]);
    }

    public static function findByEmail(string $email): ?array
    {
        return Database::fetch("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public static function all(): array
    {
        return Database::query("SELECT id, name, email, role, created_at, updated_at FROM users ORDER BY name ASC");
    }

    public static function allMembers(): array
    {
        return Database::query("SELECT id, name, email, role FROM users WHERE role = 'MEMBER' ORDER BY name ASC");
    }

    public static function create(array $data): int
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        Database::execute(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)",
            [$data['name'], $data['email'], $hashedPassword, $data['role'] ?? 'MEMBER']
        );
        return (int) Database::lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            return Database::execute(
                "UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?",
                [$data['name'], $data['email'], $hashedPassword, $data['role'], $id]
            );
        }

        return Database::execute(
            "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?",
            [$data['name'], $data['email'], $data['role'], $id]
        );
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM users WHERE id = ?", [$id]);
    }
}
