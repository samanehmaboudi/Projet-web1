<?php

namespace App\Routes;



class Route
{
    public static $routes = [];

    public static function get($page, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            self::$routes[$page] = $callback;
        }
    }

    public static function post($page, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::$routes[$page] = $callback;
        }
    }

    public static function resolve()
    {
        $page = $_GET['page'] ?? 'accueil';  

        if (isset(self::$routes[$page])) {
           call_user_func(self::$routes[$page]);
        } else {
        echo "404 - Page not found";
       }
    }

    
}
