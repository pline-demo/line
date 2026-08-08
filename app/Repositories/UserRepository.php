<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class UserRepository
{
    public function __construct(private readonly Database $database)
    {
    }

    public function findByLogin(string $login): ?array
    {
        $statement = $this->database->pdo()->prepare(
            'SELECT * FROM users WHERE username = :login OR email = :login LIMIT 1'
        );
        $statement->execute(['login' => $login]);
        $user = $statement->fetch();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->database->pdo()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $user = $statement->fetch();

        return $user ?: null;
    }
}
