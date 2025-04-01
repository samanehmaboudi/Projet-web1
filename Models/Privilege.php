<?php

namespace App\Models;

use PDO;

class Privilege
{
    private PDO $pdo;

    /**
     * Initialise la connexion à la base de données
     */
    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère tous les privilèges
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un privilège par son ID
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un privilège par son nom (admin, user, etc.)
     */
    public function getByName(string $name): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege WHERE privilege = :privilege");
        $stmt->execute(['privilege' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
