<?php 
namespace App\Providers;

use App\Providers\View;

class Auth
{
    /**
     * Vérifie la session en comparant le fingerprint (agent + IP)
     */
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
    

    

    /**
     * Vérifie que l’utilisateur a le bon privilège (admin = 2, user = 1)
     */
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
