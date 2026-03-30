<?php

class User extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FIND BY EMAIL
    |--------------------------------------------------------------------------
    */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, email, password_hash, role
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([
            'email' => strtolower(trim($email))
        ]);

        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */
    public function create(array $data): bool
    {
        // 🔒 sécurité minimale
        if (empty($data['name']) || empty($data['email']) || empty($data['password_hash'])) {
            return false;
        }

        // 🔒 email unique
        if ($this->emailExists($data['email'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password_hash, role)
            VALUES (:name, :email, :password_hash, :role)
        ");

        return $stmt->execute([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password_hash' => $data['password_hash'],
            'role' => $data['role'] ?? 'user',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, email, role
            FROM users
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL EXISTS
    |--------------------------------------------------------------------------
    */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("
            SELECT id FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([
            'email' => strtolower(trim($email))
        ]);

        return (bool) $stmt->fetch();
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD (🔥 futur reset password)
    |--------------------------------------------------------------------------
    */
    public function updatePassword(int $id, string $passwordHash): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET password_hash = :password_hash
            WHERE id = :id
        ");

        return $stmt->execute([
            'password_hash' => $passwordHash,
            'id' => $id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT USERS (🔥 admin futur)
    |--------------------------------------------------------------------------
    */
    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}