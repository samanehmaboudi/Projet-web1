<?php
namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        // Check if the connection already exists
        if (self::$pdo === null) {
            try {
                // Attempt to create a new PDO connection
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=lord_stampee;port=3307;charset=utf8',
                    'root',
                    'root',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Handle errors by throwing exceptions
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Set default fetch mode to associative array
                    ]
                );
            } catch (PDOException $e) {
                // Handle error and show a friendly message
                die("Erreur de connexion : " . $e->getMessage()); // You can replace die() with proper logging or user-friendly message
            }
        }

        // Return the existing connection
        return self::$pdo;
    }
}
