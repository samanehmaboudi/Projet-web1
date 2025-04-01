<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Providers\View;

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            return View::redirect('welcome');
        }

        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
            'login_err' => '',
            'logout_success' => isset($_GET['logout']) ? "Vous êtes déconnecté." : ''
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['email'] = trim($_POST["email"]);
            $data['password'] = trim($_POST["password"]);

            if (empty($data['email'])) $data['email_err'] = "Veuillez entrer votre email.";
            if (empty($data['password'])) $data['password_err'] = "Veuillez entrer votre mot de passe.";

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $userModel = new User();
                $user = $userModel->findByEmail($data['email']);

                if ($user && password_verify($data['password'], $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["username"] = $user['name'];
                    $_SESSION["privilege"] = $user['user_privilege'];
                    $_SESSION["fingerPrint"] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);

                    return View::redirect('welcome');
                } else {
                    $data['login_err'] = "Email ou mot de passe invalide.";
                }
            }
        }

        return View::render('auth/login', $data);
    }

    public function register()
    {
        $data = $this->getRegisterData();

        //Si connecte, redirige vers welcome ou deconnecte
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $this->handleRegistration($data, 'user');
        }

        return View::render('auth/register', $data);
    }

    public function registerAdmin()
    {
        $data = $this->getRegisterData();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = $this->handleRegistration($data, 'admin');
        }

        return View::render('auth/register', $data);
    }

    public function changePrivilege()
{
    session_start();

    // Vérifier que l'utilisateur est connecté et est un admin
    if (!isset($_SESSION["loggedin"]) || $_SESSION["privilege"] != 2) {
        return View::redirect('login');
    }

    // Vérifie qu’un ID est passé dans l’URL (ex: ?id=3&role=admin)
    $userId = $_GET['id'] ?? null;
    $role = $_GET['role'] ?? null;

    if ($userId && $role) {
        $privilegeModel = new Privilege();
        $roleData = $privilegeModel->getByName($role); 

        if ($roleData) {
            $userModel = new User();
            $userModel->updatePrivilege((int) $userId, $roleData['id']);
        }
    }

    return View::redirect('admin-users'); 
}


    public function resetPassword()
    {
        $data = [
            'email' => '',
            'email_err' => '',
            'reset_success' => ''
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['email'] = trim($_POST["email"]);

            if (empty($data['email'])) {
                $data['email_err'] = "Veuillez entrer votre email.";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = "Format d'email invalide.";
            }

            if (empty($data['email_err'])) {
                $data['reset_success'] = "Un lien de réinitialisation vous a été envoyé (non fonctionnel).";
            }
        }

        return View::render('auth/resetPassword', $data);
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        return View::redirect('login');
    }

    

    private function getRegisterData(): array
    {
        return [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'username_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];
    }

    private function handleRegistration(array $data, string $role): array
    {
        $data['username'] = trim($_POST["username"]);
        $data['email'] = trim($_POST["email"]);
        $data['password'] = trim($_POST["password"]);
        $data['confirm_password'] = trim($_POST["confirm_password"]);

        if (empty($data['username'])) $data['username_err'] = "Veuillez entrer un nom d'utilisateur.";
        if (empty($data['email'])) {
            $data['email_err'] = "Veuillez entrer un email.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email_err'] = "Format d'email invalide.";
        }

        if (empty($data['password'])) $data['password_err'] = "Veuillez entrer un mot de passe.";
        if ($data['password'] !== $data['confirm_password']) {
            $data['confirm_password_err'] = "Les mots de passe ne correspondent pas.";
        }

        if (empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            $userModel = new User();
            if ($userModel->exists($data['email'])) {
                $data['email_err'] = "Cet email est déjà utilisé.";
            } else {
                $privilege = new Privilege();
                $roleData = $privilege->getByName($role);

                $userModel->create([
                    'name' => $data['username'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'privilege_id' => $roleData['id']
                ]);
                
                $_SESSION['flash'] = "Inscription réussie.";
                View::redirect('login');
                exit;
            }
        }

        return $data;
    }
}
