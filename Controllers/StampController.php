<?php 

namespace App\Controllers;

use App\Models\Stamp;
use App\Providers\View;

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


    public function create()
    {
        session_start();
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }
    
        return View::render('admin/stamps/create-stamp');
    }

    public function store()
    {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Stamp();
    
            $data = [
                'name' => $_POST['name'],
                'creationDate' => $_POST['creationDate'],
                'user_id' => $_SESSION['user_id'],
                'condition_id' => $_POST['condition_id'],
                'country_id' => $_POST['country_id'],
                'category_id' => $_POST['category_id'],
                'color_id' => $_POST['color_id'],
                'price' => $_POST['price']
            ];
    
            $stampId = $model->create($data);
    
            // Traitement image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $filename = uniqid() . '-' . $_FILES['image']['name'];
                $path = 'public/assets/images/uploads/' . $filename;
                move_uploaded_file($_FILES['image']['tmp_name'], 'public/' . $path);
    
                $model->addImage($stampId, $path, 'Main');
            }
    
            $_SESSION['flash'] = "Timbre ajouté avec succès !";
            return View::redirect('catalogue');
        }
    
        return View::redirect('admin/stamps/create-stamp');
    }
    
    
    
}
