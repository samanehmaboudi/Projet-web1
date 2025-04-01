<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Database;
use App\Models\CRUD;
use App\Providers\View;

class AdminController
{
    // Tableau de bord
    public function dashboard()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] != 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        return View::render("admin/dashboard", [
            'session' => $_SESSION,
        ]);
    }

    // Liste des utilisateurs
    public function listUsers()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] != 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->query("
            SELECT u.id, u.name, u.email, p.privilege AS role
            FROM User u
            LEFT JOIN Privilege p ON u.privilege_id = p.id
        ");
        $users = $stmt->fetchAll();

        return View::render("admin/users", [
            'users' => $users,
        ]);
    }

    // Modifier un utilisateur
    public function editUser()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] != 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID utilisateur manquant.";
            return;
        }

        $pdo = Database::getConnection();
        $userCrud = new CRUD($pdo, 'User');
        $privCrud = new CRUD($pdo, 'Privilege');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCrud->update($id, [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'privilege_id' => $_POST['role']
            ]);
            $_SESSION['flash'] = "Utilisateur modifié.";
            return View::redirect('admin-users');
        }

        $user = $userCrud->find($id);
        $privileges = $privCrud->all();

        return View::render("admin/edit-user", [
            'user' => $user,
            'privileges' => $privileges,
        ]);
    }

    // Rendre admin
    public function makeAdmin()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] != 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $pdo = Database::getConnection();
            $userCrud = new CRUD($pdo, 'User');
            $userCrud->update($id, ['privilege_id' => 2]);
        }

        return View::redirect('admin-users');
    }

    // Supprimer un utilisateur
    public function deleteUser()
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] != 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $pdo = Database::getConnection();
            $userCrud = new CRUD($pdo, 'User');
            $userCrud->delete($id);
        }

        return View::redirect('admin-users');
    }
}
