<?php
namespace toubilib\infra\repositories;

use toubilib\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
use toubilib\core\domain\entities\User;

class PDOAuthReposiroty implements AuthRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findById(string $id): User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new User(
            id: $row['id'],
            email: $row['email'],
            password: $row['password'],
            role: $row['role']
        );
    }
}