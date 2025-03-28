<?php

namespace App\Models;

use App\Models\CRUD;
use App\Models\Database;

class UserStore
{
    private $crud;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->crud = new CRUD($pdo, 'User');
    }

    public function getAll()
    {
        return $this->crud->all();
    }

    public function find($id)
    {
        return $this->crud->find($id);
    }

    public function update($id, $data)
    {
        return $this->crud->update($id, $data);
    }

    public function delete($id)
    {
        return $this->crud->delete($id);
    }

    public function exists($email)
    {
        $users = $this->crud->all();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    public function create($data)
    {
        return $this->crud->create($data);
    }

    public function findByEmail(string $email)
{
    $users = $this->getAll(); // ou $this->crud->all();

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }

    return null;
}

}
