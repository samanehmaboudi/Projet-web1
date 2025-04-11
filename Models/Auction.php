<?php

namespace App\Models;

use App\Models\Database;
use PDO;

class Auction
{
    
    public static function findByStampId($stampId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM Auction WHERE Stamp_id = ?");
        $stmt->execute([$stampId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public static function findById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM Auction WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public static function create($data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO Auction (start_date, end_date, starting_price, Stamp_id)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['start_date'],
            $data['end_date'],
            $data['starting_price'],
            $data['stamp_id']
        ]);
    }
}
