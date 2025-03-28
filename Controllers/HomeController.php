<?php 
namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class HomeController
{
    public function index()
    {
        session_start();

        // Redirection si l'utilisateur n'est pas connecté
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: index.php?page=login");
            exit;
        }

        // Charger Twig pour afficher la vue
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader);

        // Passer les données nécessaires à la vue
        $data = [
            "asset" => ASSET,
            "session" => $_SESSION
        ];

        // Rendre la vue pageAccueil.twig
        echo $twig->render('pages/pageAccueil.twig', $data);
    }
}
