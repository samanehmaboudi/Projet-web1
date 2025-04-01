<?php

namespace App\Models;

use App\Models\CRUD;
use App\Models\Database;
use PDO;

class User extends CRUD
{
    protected string $table = 'User';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'email', 'password', 'privilege_id'];

    public function __construct()
    {
        parent::__construct(Database::getConnection(), $this->table);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkUser(string $email, string $password): bool
    {
        $user = $this->unique('email', $email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['privilege'] = $user['privilege_id'];
            $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            return true;
        }

        return false;
    }

    public function findByEmail(string $email): array|false
    {
        $sql = "SELECT u.id, u.name, u.email, u.password, p.privilege AS user_privilege
                FROM User u
                LEFT JOIN Privilege p ON u.privilege_id = p.id
                WHERE u.email = :email";

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function exists(string $email): bool
    {
        $sql = "SELECT id FROM User WHERE email = :email";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function create(array $data): bool
    {
        $data['password'] = $this->hashPassword($data['password']);
        return parent::create($data);
    }
    

    public function updatePrivilege(int $id, int $privilege_id): bool
    {
        return $this->update($id, ['privilege_id' => $privilege_id]);
    }
}
