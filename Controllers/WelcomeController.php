<?php

namespace App\Controllers;

use App\Providers\View;

class WelcomeController
{
   
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
    

   
    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: /login");
        exit;
    }
}
