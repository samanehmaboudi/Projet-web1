<?php
namespace App\Models;

use PDO;

class Privilege
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Privilege WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function getByName($name)
{
    $stmt = $this->pdo->prepare("SELECT * FROM Privilege WHERE privilege = :privilege");
    $stmt->execute(['privilege' => $name]);    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
