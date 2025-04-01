<?php

namespace App\Controllers;

use App\Providers\View;

class HomeController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        // Vérifier si l'utilisateur est connecté
        // if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        //     $_SESSION['flash'] = "Veuillez vous connecter pour accéder à la page d’accueil.";
        //     header("Location: /login");
        //     exit;
        // }

        // Rendu de la vue avec les données de session
        return View::render('pages/pageAccueil', [
            'title' => 'Accueil',
        ]);
        
    }
}
