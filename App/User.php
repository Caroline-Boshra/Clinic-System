<?php

namespace App;

use PDO;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $role;
    private string $password;
    private ?string $phone;

    public function __construct(int $id, string $name, string $email, string $role, string $password = '', ?string $phone = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->phone = $phone;
    }

    public function __get(string $property): mixed
    {
        if ($property === 'id') {
            return $this->id;
        } elseif ($property === 'name') {
            return $this->name;
        } elseif ($property === 'email') {
            return $this->email;
        } elseif ($property === 'role') {
            return $this->role;
        } elseif ($property === 'password') {
            return $this->password;
        } elseif ($property === 'phone') {
            return $this->phone;
        }
        return null;
    }

    public static function create(PDO $pdo, string $name, string $email, string $role, string $password, ?string $phone = null): ?User
    {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, role, password, phone) VALUES (?, ?, ?, ?, ?)");
        $success = $stmt->execute([$name, $email, $role, $password, $phone]);
        if ($success) {
            $id = (int) $pdo->lastInsertId();
            return new self($id, $name, $email, $role, $password, $phone);
        }

        return null;
    }

    public static function getAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT id, name, email, role, password, phone FROM users");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = new self(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['role'],
                $row['password'] ?? '',
                $row['phone'] ?? null
            );
        }
        return $users;
    }

    public static function findById(PDO $pdo, int $id): ?User
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['role'],
                $row['password'] ?? '',
                $row['phone'] ?? null
            );
        }

        return null;
    }

    public static function findByEmail(PDO $pdo, string $email): ?User
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['role'],
                $row['password'] ?? '',
                $row['phone'] ?? null
            );
        }

        return null;
    }
}
