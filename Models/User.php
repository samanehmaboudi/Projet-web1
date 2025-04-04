<?php 

namespace App\Models;

use App\Models\Database;
use App\Models\CRUD;
use PDO;

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

   
    public function getAllWithPrivilege(): array
    {
        $sql = "
            SELECT u.id, u.name, u.email, p.privilege AS role
            FROM User u
            LEFT JOIN Privilege AS p ON u.privilege_id = p.id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updatePrivilege(int $userId, int $privilegeId): bool
    {
        $sql = "UPDATE User SET privilege_id = :privilege_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'privilege_id' => $privilegeId,
            'id' => $userId
        ]);
    }


    public function exists(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM User WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetch();
    }

    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    

   
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM User WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

   
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO User (name, email, password, privilege_id)
            VALUES (:name, :email, :password, :privilege_id)
        ";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE User SET name = :name, email = :email, privilege_id = :privilege_id
            WHERE id = :id
        ";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

 
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM User WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function find($id) {
        $sql = "SELECT * FROM User WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}