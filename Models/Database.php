<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    // Connexion PDO unique (singleton)
    private static ?PDO $pdo = null;

    /**
     * Retourne une connexion PDO à la base de données
     */
    public static function getConnection(): PDO
    {
        // Si la connexion n'existe pas encore, on la crée
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
                // En cas d’erreur, on affiche un message simple
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        // Retourne la connexion existante
        return self::$pdo;
    }
}
