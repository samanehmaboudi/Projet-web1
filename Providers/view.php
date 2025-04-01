<?php

namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    /**
     * Rend une vue Twig avec données + variables globales
     */
    static public function render($template, $data = [])
    {
        // Ne pas ajouter .twig automatiquement, on s'attend à des fichiers .php contenant du Twig
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        // Variables globales accessibles partout
        $twig->addGlobal('asset', ASSET);   
        $twig->addGlobal('base', BASE);     // L’URL de base
        $twig->addGlobal('session', $_SESSION); // Données session

        // Vérifie si l’utilisateur est un invité
        $guest = true;
        if (
            isset($_SESSION['fingerPrint']) &&
            $_SESSION['fingerPrint'] === md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])
        ) {
            $guest = false;
        }
        $twig->addGlobal('guest', $guest);

       
        echo $twig->render($template.".php", $data);
    }

    /**
     * Redirige vers une autre page
     */
    static public function redirect($url)
    {
        header('Location: ' . BASE . '/' . $url);
        exit;
    }
}
