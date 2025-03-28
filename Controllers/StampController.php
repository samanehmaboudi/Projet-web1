<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use PDO;
use App\Models\Database; 

class StampController

{
    private $pdo;

    
    public function __construct()
    {
       
        $this->pdo = Database::getConnection(); 
    }

    public function catalogue()
    {
        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: index.php?page=login");
            exit;
        }

        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader);

        echo $twig->render('pages/catalogueProduit.twig', [
            "session" => $_SESSION,
            "asset" => ASSET
        ]);
    }

    public function ficheProduit()
{
    session_start();

    
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: index.php?page=login");
        exit;
    }

    
    $productId = $_GET['id'] ?? null;

    if ($productId) {
      
        $stmt = $this->pdo->prepare("SELECT * FROM stamp WHERE id = :id");   
        $stmt->execute(['id' => $productId]);
        $produit = $stmt->fetch();

        if ($produit) {
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $twig = new Environment($loader);

            echo $twig->render('pages/fiche-produit.twig', [
                'produit' => $produit,
                'asset' => ASSET,
                'session' => $_SESSION
            ]);
        } else {
            echo "Produit non trouvé";
        }
    } else {
        echo "Aucun produit sélectionné";
    }
   }

}
