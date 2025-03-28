<?php
namespace App\Models;

use PDO;

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail($email)
    {
        $sql = "SELECT u.id, u.name, u.email, u.password, p.privilege AS user_privilege
                FROM User u
                LEFT JOIN Privilege p ON u.privilege_id = p.id
                WHERE u.email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exists($email)
    {
        $sql = "SELECT id FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function create($name, $email, $password, $privilege_id)
    {
        $sql = "INSERT INTO User (name, email, password, privilege_id)
                VALUES (:name, :email, :password, :privilege_id)";
    
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':privilege_id' => $privilege_id
        ]);
    }
    


    public function findById($id)
    {
        $sql = "SELECT * FROM User WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
{
    $stmt = $this->pdo->query("
        SELECT u.id, u.name, u.email, p.privilege AS role 
        FROM User u
        LEFT JOIN Privilege p ON u.privilege_id = p.id
    ");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
