<?php

namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;



class UserController
{
    
    public function profil()
    {
        session_start();

        
        if (!isset($_SESSION['user_id'])) {
            return View::redirect('login');
        }

        
        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);

        
        return View::render('user/profil', [
            'user' => $user
        ]);
    }


    public function create()
    {
        return View::render('user/create');
    }

    public function store()
    {
        $validator = new Validator;
        $validator->field('name', $_POST['name'])->required()->min(3)->max(50);
        $validator->field('email', $_POST['email'])->required()->email();
        $validator->field('password', $_POST['password'])->required()->min(6);
        $validator->field('privilege_id', $_POST['privilege_id'])->required();

        if ($validator->isSuccess()) {
            $user = new User;
            $user->create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $user->hashPassword($_POST['password']),
                'privilege_id' => $_POST['privilege_id']
            ]);

            return View::redirect('admin/admin-users');
        } else {
            $errors = $validator->getErrors();
            return View::render('user/create', [
                'errors' => $errors,
                'user' => $_POST
            ]);
        }
    }

    
    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return View::redirect('login');
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userModel = new User();

            $updatedData = [
                'name'  => trim($_POST['name']),
                'email' => trim($_POST['email'])
            ];

            
            $userModel->update($_SESSION['user_id'], $updatedData);

            return View::redirect('profil');
        }

        // Si ce n'est pas un POST, on redirige
        return View::redirect('profil');
    }

    
    
}
