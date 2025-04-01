<?php

namespace App\Controllers;

use App\Providers\View;
use App\Models\Database;

class StampController
{
    private $pdo;

    public function __construct()
    {
        // Connexion à la base de données via le modèle Database
        $this->pdo = Database::getConnection();
    }

    /**
     * Affiche la page de catalogue des produits (timbres)
     */
    public function catalogue()
    {
        session_start();

        // Vérification de la session
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            $_SESSION['flash'] = "Veuillez vous connecter pour accéder au catalogue.";
            header("Location: /login");
            exit;
        }

        // Rendu de la vue du catalogue
        return View::render('pages/catalogueProduit', [
            'session' => $_SESSION,
            'asset' => ASSET
        ]);
    }

    /**
     * Affiche la fiche détaillée d’un produit (timbre)
     */
    public function ficheProduit()
    {
        session_start();

        // Vérification de l'utilisateur connecté
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            $_SESSION['flash'] = "Connexion requise pour voir ce timbre.";
            header("Location: /login");
            exit;
        }

        // Récupérer l’ID depuis l’URL
        $productId = $_GET['id'] ?? null;

        if (!$productId) {
            echo "Aucun produit sélectionné.";
            return;
        }

        // Requête pour récupérer les données du timbre
        $stmt = $this->pdo->prepare("SELECT * FROM stamp WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $produit = $stmt->fetch();

        if (!$produit) {
            echo "Produit non trouvé.";
            return;
        }

        // Rendu de la fiche produit
        return View::render('pages/fiche-produit', [
            'produit' => $produit,
            'asset' => ASSET,
            'session' => $_SESSION
        ]);
    }
}
