<?php
namespace Clinic;

use PDO;

class UserFunctions
{
    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?User
    {
        $st = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch();
        return $row ? User::fromRow($row) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $st = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $st->execute([$email]);
        $row = $st->fetch();
        return $row ? User::fromRow($row) : null;
    }

    public function exists(string $email, string $phone): bool
    {
        $st = $this->pdo->prepare('SELECT id FROM users WHERE email = ? OR phone = ?');
        $st->execute([$email, $phone]);
        return (bool)$st->fetch();
    }

    /** @return User[] */
    public function all(): array
    {
        $rows = $this->pdo->query('SELECT * FROM users ORDER BY id')->fetchAll();
        return array_map([User::class, 'fromRow'], $rows);
    }

    
    public function create(User $user): int
    {
        $row = $user->toRow();
        $st  = $this->pdo->prepare(
            'INSERT INTO users (first_name, last_name, email, phone, password, role, birth_date)
             VALUES (:first_name, :last_name, :email, :phone, :password, :role, :birth_date)'
        );
        $st->execute($row);
        $id = (int)$this->pdo->lastInsertId();
        $user->setId($id);
        return $id;
    }

    public function update(User $user): void
    {
        $st = $this->pdo->prepare(
            'UPDATE users SET first_name=?, last_name=?, phone=?, birth_date=? WHERE id=?'
        );
        $st->execute([
            $user->getFirstName(), $user->getLastName(),
            $user->getPhone(), $user->getBirthDate(), $user->getId(),
        ]);
    }

    public function delete(int $id): void
    {
        $this->pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    }
}