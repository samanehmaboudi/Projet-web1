<?php

namespace App\Models;

use PDO;

class CRUD
{
    private $pdo;
    private $table;

    /**
     * Constructeur : initialise la connexion PDO et le nom de la table
     */
    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }


    public function unique(string $column, mixed $value): array|false
{
    $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['value' => $value]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


  
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public function find(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

   
    public function update(int $id, array $data): bool
    {
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

       
        $data['id'] = $id;

        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

 
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
