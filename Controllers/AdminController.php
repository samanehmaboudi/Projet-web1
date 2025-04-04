<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Providers\View;
use App\Providers\Database;

class AdminController
{
    public function dashboard()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }

        return View::render('admin/dashboard');
    }

    public function listUsers()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $model = new User();
        $users = $model->getAllWithPrivilege();

        return View::render("admin/admin-users", [
            'users' => $users,
        ]);
    }

    public function editUser()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID utilisateur manquant.";
            return;
        }

        $userModel = new User();
        $privilegeModel = new Privilege();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel->update($id, [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'privilege_id' => $_POST['role']
            ]);
            $_SESSION['flash'] = "Utilisateur modifié.";
            return View::redirect('admin/admin-users');
        }

        $user = $userModel->findById($id);
        $privileges = $privilegeModel->getAll();

        return View::render("admin/edit-user", [
            'user' => $user,
            'privileges' => $privileges,
        ]);
    }

    public function makeAdmin()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $model = new User();
            $model->update($id, ['privilege_id' => 2]);
        }

        return View::redirect('admin/admin-users');
    }

    public function deleteUser()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            $_SESSION['flash'] = "Accès refusé.";
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $model = new User();
            $model->delete($id);
        }

        return View::redirect('admin/admin-users');
    }
}
