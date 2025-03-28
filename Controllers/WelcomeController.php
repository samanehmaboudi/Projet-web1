<?php 
namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class WelcomeController
{
    public function welcome()
    {
        session_start();
    
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: index.php?page=login");
            exit;
        }
    
        // Récupérer l'email de l'utilisateur
        $username = $_SESSION["username"];
        $privilege = $_SESSION["privilege"];  // Le privilège de l'utilisateur (user ou admin)
    
        $loader = new FilesystemLoader(__DIR__ . '/../views/auth');
        $twig = new Environment($loader, [
            'cache' => false  // Désactivation du cache pendant le développement
        ]);
    
        // Données à afficher dans la vue
        $data = [
            'username' => $_SESSION["username"],
            'privilege' => $_SESSION["privilege"],
            'asset' => '/projet-web-Lode-stampee/public'
        ];
        
    
        echo $twig->render('welcome.twig', $data);
    }
    


    public function logout()
    {
        // Détruire la session à la déconnexion
        session_start();
        $_SESSION = [];
        session_destroy();
    
        // Rediriger vers la page de login après déconnexion
        header("Location: index.php?page=login");
        exit;
    }

}
