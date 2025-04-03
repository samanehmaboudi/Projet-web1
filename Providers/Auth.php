<?php 
namespace App\Providers;

use App\Providers\View;

class Auth
{

    public static function session()
    {
        if (isset($_SESSION['fingerPrint']) &&
            $_SESSION['fingerPrint'] === md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) {
            return true;
        } else {
            return View::redirect('login');
            exit();
        }
    }  

    public static function superadminOnly()
    {
   
        if (
            !isset($_SESSION['privilege_id']) ||
            $_SESSION['privilege_id'] != 3
        ) {
            return View::redirect('login');
            exit;
        }
    }
    

    public static function privilege($id)
    {
        if ($_SESSION['privilege_id'] == $id) {
            return true;
        } else {
            return View::redirect('login');
            exit();
        }
    }
}
