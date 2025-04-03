<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
   
    private static ?PDO $pdo = null;

    
    public static function getConnection(): PDO
    {
       
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=lord_stampee;port=3307;charset=utf8',
                    'root',
                    'root',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        
        return self::$pdo;
    }
}
