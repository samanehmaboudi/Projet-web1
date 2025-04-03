<?php

namespace App\Models;

use PDO;

class Privilege
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM Privilege");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getByName(string $name): ?array
    {
        $sql = "SELECT * FROM Privilege WHERE privilege = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    
}
