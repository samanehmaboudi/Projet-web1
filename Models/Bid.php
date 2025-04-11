<?php

namespace App\Models;

use App\Models\Database;
use PDO;



class Bid
{
   
    public static function create($data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO Bid (amount, Auction_id, User_id) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['amount'],
            $data['auction_id'],
            $data['user_id']
        ]);
    }

  
    public static function getAllByAuctionId($auctionId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT b.amount, b.date, u.name AS user_name
            FROM Bid b
            JOIN User u ON b.User_id = u.id
            WHERE b.Auction_id = ?
            ORDER BY b.date DESC
        ");
        $stmt->execute([$auctionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
