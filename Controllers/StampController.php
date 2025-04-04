<?php 

namespace App\Controllers;

use App\Models\Stamp;
use App\Providers\View;
use App\Models\CRUD;

class StampController
{
    public function catalogue()
    {
        $model = new Stamp();
        $stamps = $model->getAllWithImages();

        return View::render('pages/catalogueProduit', [
            'stamps' => $stamps
        ]);
    }

    public function ficheProduit()
    {
        if (!isset($_GET['id'])) {
            return View::redirect('catalogue');
        }
    
        $id = intval($_GET['id']);
        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);
    
        if (!$stamp) {
            return View::redirect('catalogue');
        }
    
        $relatedStamps = $model->getRelatedStamps($id);
    
        return View::render('pages/fiche-produit', [
            'stamp' => $stamp,
            'relatedStamps' => $relatedStamps
        ]);
    }

    public function adminStamps()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        $model = new Stamp();
        $stamps = $model->getAllWithImages();
    
        return View::render('admin/stamps/index', [
            'stamps' => $stamps
        ]);
    }
    

      
    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        $pdo = \App\Models\Database::getConnection();
    
        $conditionCrud = new CRUD($pdo, 'Stamp_Condition');
        $countryCrud = new CRUD($pdo, 'Country');
        $categoryCrud = new CRUD($pdo, 'Category');
        $colorCrud = new CRUD($pdo, 'Color');
    
        return View::render('admin/stamps/create-stamp', [
            'conditions' => $conditionCrud->all(),
            'countries' => $countryCrud->all(),
            'categories' => $categoryCrud->all(),
            'colors' => $colorCrud->all()
        ]);
    }
      
    public function store()
    {
        
      
        
        if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        // Validation basique
        $errors = [];
        if (empty($_POST['name'])) $errors[] = "Le nom est requis.";
        if (empty($_POST['creationDate'])) $errors[] = "L'année de création est requise.";
    
        if (!empty($errors)) {
            return View::render('admin/stamps/create-stamp', [
                'errors' => $errors
            ]);
        }
    
        
        $year = $_POST['creationDate']; 
        $fullDate = $year . '-01-01';   
    
        $stamp = new Stamp();
        $stamp->create([
            'name' => $_POST['name'],
            'creationDate' => $fullDate,
            'condition_id' => $_POST['condition_id'],
            'country_id' => $_POST['country_id'],
            'category_id' => $_POST['category_id'],
            'color_id' => $_POST['color_id'],
            'user_id' => $_SESSION['user_id'] ?? null
        ]);
    
        
        $_SESSION['flash'] = "Timbre ajouté avec succès.";
        return View::redirect('admin-stamps');
    }

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = "ID de timbre manquant.";
            return View::redirect('admin-stamps');
        }
    
        $model = new Stamp();
        $model->delete($id);
    
        $_SESSION['flash'] = "Timbre supprimé avec succès.";
        return View::redirect('admin-stamps');
    }  


    public function edit()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = "ID du timbre manquant.";
            return View::redirect('admin-stamps');
        }
    
        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);
    
        if (!$stamp) {
            $_SESSION['flash'] = "Timbre non trouvé.";
            return View::redirect('admin/stamps/admin-stamps');
        }
    
        return View::render('admin/stamps/edit-stamp', [
            'stamp' => $stamp
        ]);
    }


    public function show()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            $_SESSION['flash'] = "ID timbre manquant.";
            return View::redirect('admin/stamps/admin-stamps');
        }
    
        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);
    
        if (!$stamp) {
            $_SESSION['flash'] = "Timbre non trouvé.";
            return View::redirect('admin/stamps/admin-stamps');
        }
    
        return View::render('admin/stamps/show-stamp', [
            'stamp' => $stamp
        ]);
    }
    
      

    
      
    
    
    
    
}
