<?php

namespace App\Controllers;

use App\Providers\View;

class WelcomeController
{
    /**
     * Affiche la page de bienvenue si l’utilisateur est connecté
     */
    public function welcome()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: /login");
            exit;
        }
    
        return View::render('auth/welcome', [
            'username' => $_SESSION["username"],
            'privilege' => $_SESSION["privilege"],
            'asset' => ASSET
        ]);
    }
    

    /**
     * Déconnecte l’utilisateur et redirige vers la page de login
     */
    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: /login");
        exit;
    }
}
