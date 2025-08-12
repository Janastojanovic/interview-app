<?php

declare(strict_types=1);

namespace App\Data\Repository;

use App\Application\DTOs\UserRegisterDto;
use App\Data\Models\User;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Presentation\Exceptions\UserRegistrationException;
use PDO;

class UserRepository extends GenericRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare(
            'SELECT *
             FROM users
             WHERE email = ?'
        );

        $stmt->execute([$email]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $stmt->fetch();

        return $user ?: null;
    }
    public function register(UserRegisterDto $user): ?int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users(email,password)
            VALUES (:email, :password)'
        );

        $result = $stmt->execute([
            ':email' => $user->email,
            ':password' => password_hash($user->password, PASSWORD_DEFAULT)
        ]);

        return $result ? (int)$this->db->lastInsertId() : null;
    }

    public function isMailTaken(string $email): bool
    {
        $stmt = $this->db->prepare(
            'SELECT 1
         FROM users
         WHERE email = ?
         LIMIT 1'
        );

        $stmt->execute([$email]);
        $result = $stmt->fetchColumn();

        return $result !== false;
    }
}
