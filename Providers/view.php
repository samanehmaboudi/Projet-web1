<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    public static function twig()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        return new Environment($loader, [
            'debug' => true,
            'cache' => false 
        ]);
    }
}
