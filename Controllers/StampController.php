<?php

namespace App\Controllers;

use App\Models\Stamp;
use App\Providers\View;
use App\Models\CRUD;
use App\Models\Bid;
use App\Models\Auction;

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
        session_start();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            return View::redirect('catalogue');
        }

        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);
        if (!$stamp) {
            return View::redirect('catalogue');
        }


        $auction = Auction::findByStampId($id);
        $minimum_bid = null;
        $bids = [];

        if ($auction) {
            $stamp['auction_id'] = $auction['id'];
            $bids = Bid::getAllByAuctionId($auction['id']);

            $minimum_bid = $auction['starting_price'];
            if (!empty($bids)) {
                $max = max(array_column($bids, 'amount'));
                $minimum_bid = $max + 1;
            }
        }

        return View::render('pages/fiche-produit', [
            'stamp' => $stamp,
            'user' => $_SESSION['user'] ?? null,
            'minimum_bid' => $minimum_bid,
            'bids' => $bids
        ]);
    }


    public function adminStamps()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            return View::redirect('login');
        }

        $model = new Stamp();
        $stamps = $model->getAllWithImages();

        return View::render('admin/stamps/admin-stamp', [
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
        if (session_status() === PHP_SESSION_NONE) session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $model = new Stamp();
    
            $userId = $_SESSION['user']['id'] ?? null;
            $year = $_POST['creationDate'];
            $fullDate = $year . "-01-01";
    
            $data = [
                'name' => $_POST['name'],
                'creationDate' => $fullDate,
                'user_id' => $userId,
                'condition_id' => $_POST['condition_id'],
                'country_id' => $_POST['country_id'],
                'category_id' => $_POST['category_id'],
                'color_id' => $_POST['color_id'],
                'price' => $_POST['price'],
                'description' => $_POST['description'] ?? ''
            ];
    
            $stampId = $model->createAndGetId($data);
    
            
            $uploadDir = 'assets/images/uploads/';
    
           
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                    if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
    
                        $filename = uniqid() . '-' . basename($_FILES['images']['name'][$index]);
                        $targetPath = $uploadDir . $filename;
    
                        
                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $type = $index === 0 ? 'Main' : 'Additional';
                            $model->addImage($stampId, $targetPath, $type);
                        }
                    }
                }
            }
    
            $_SESSION['flash'] = "Timbre ajouté avec succès !";
            return View::redirect('admin-stamp'); // catalogue,, 'admin-stamp'
        }
    
        return View::redirect('create-stamp');
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
            return View::redirect('admin-stamp');
        }

        $model = new Stamp();
        $model->delete($id);

        $_SESSION['flash'] = "Timbre supprimé avec succès.";
        return View::redirect('admin-stamp');
    }


    public function edit()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] < 2) {
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash'] = "ID du timbre manquant.";
            return View::redirect('admin-stamp');
        }

        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);

        if (!$stamp) {
            $_SESSION['flash'] = "Timbre non trouvé.";
            return View::redirect('admin-stamp');
        }

        return View::render('admin/stamps/edit-stamp', [
            'stamp' => $stamp
        ]);
    }


    public function show()
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['privilege_id'] > 2) {
            return View::redirect('login');
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['flash'] = "ID timbre manquant.";
            return View::redirect('admin-stamp');
        }

        $model = new Stamp();
        $stamp = $model->findByIdWithImages($id);

        if (!$stamp) {
            $_SESSION['flash'] = "Timbre non trouvé.";
            return View::redirect('admin-stamp');
        }

        return View::render('admin/stamps/show-stamp', [
            'stamp' => $stamp
        ]);
    }
}
