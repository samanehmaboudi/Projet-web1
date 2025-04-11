<?php

namespace App\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Providers\View;



class AuctionController
{
  
    public function placeBid()
    {
        session_start();
    
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash'] = "Vous devez être connecté pour miser.";
            return View::redirect('login');
        }
    
        $userId = $_SESSION['user']['id'];
        $amount = $_POST['amount'] ?? null;
        $auctionId = $_POST['auction_id'] ?? null;
    
        if (!$amount || !$auctionId) {
            $_SESSION['flash'] = "Erreur : Données de mise manquantes.";
            return View::redirect('catalogue');
        }
    
        $auction = Auction::findById($auctionId);
        if (!$auction) {
            $_SESSION['flash'] = "Enchère introuvable.";
            return View::redirect('catalogue');
        }
    
        if (strtotime($auction['end_date']) < time()) {
            $_SESSION['flash'] = "Enchère terminée.";
            return View::redirect("fiche-produit?id=" . $auction['Stamp_id']);
        }
    
        // 🔍 Vérifie montant minimum
        $bids = Bid::getAllByAuctionId($auctionId);
        $minimum = $auction['starting_price'];
    
        if (!empty($bids)) {
            $max = max(array_column($bids, 'amount'));
            $minimum = $max + 1;
        }
    
        if ($amount < $minimum) {
            $_SESSION['flash'] = "Votre mise doit être d'au moins {$minimum} $.";
            return View::redirect("fiche-produit?id=" . $auction['Stamp_id']);
        }
    
        Bid::create([
            'amount' => $amount,
            'auction_id' => $auctionId,
            'user_id' => $userId
        ]);
    
        $_SESSION['flash'] = " Mise enregistrée avec succès !";
        return View::redirect("fiche-produit?id=" . $auction['Stamp_id']);
    }
    
}
