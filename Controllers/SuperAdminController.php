<?php
namespace App\Controllers;

use App\Providers\View;
use App\Providers\Auth;

class SuperAdminController
{
    public function dashboard()
    {
        session_start();
        Auth::superadminOnly();

        return View::render('superadmin/dashboard', [
            'title' => 'SuperAdmin Dashboard'
        ]);
    }
}
