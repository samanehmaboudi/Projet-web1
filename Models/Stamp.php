<?php 

namespace App\Models;

use App\Models\Database;
use PDO;

class Stamp
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }


    public function create(array $data): int
    {
        $sql = "INSERT INTO Stamp (name, creationDate, User_id, condition_id, country_id, category_id, color_id, price)
                VALUES (:name, :creationDate, :user_id, :condition_id, :country_id, :category_id, :color_id, :price)";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    
        return $this->pdo->lastInsertId();
    }
    
    public function addImage(int $stampId, string $url, string $type = 'Main'): void
    {
        $sql = "INSERT INTO Image (image_url, image_type, Stamp_id) VALUES (:url, :type, :stamp_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'url' => $url,
            'type' => $type,
            'stamp_id' => $stampId
        ]);
    }
    







    public function getAllWithImages(): array
    {
        $sql = "SELECT s.id, s.name, s.creationDate, s.price, i.image_url
        FROM Stamp s
        LEFT JOIN Image i ON s.id = i.Stamp_id
        WHERE i.image_type = 'Main'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByIdWithImages(int $id): ?array
    {
        $sql = "SELECT s.*, i.image_url, i.image_type,
               c.name as country_name,
               cond.name as condition_name,
               cat.name as category_name,
               col.name as color_name
        FROM Stamp s
        LEFT JOIN Image i ON s.id = i.Stamp_id
        LEFT JOIN Country c ON s.country_id = c.id
        LEFT JOIN Stamp_Condition cond ON s.condition_id = cond.id
        LEFT JOIN Category cat ON s.category_id = cat.id
        LEFT JOIN Color col ON s.color_id = col.id
        WHERE s.id = :id";

    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$results) return null;
    
        $stamp = $results[0];
        $stamp['images'] = [];
    
        foreach ($results as $row) {
            if ($row['image_url']) {
                $stamp['images'][] = [
                    'image_url' => $row['image_url'],
                    'image_type' => $row['image_type']
                ];
            }
        }
    
        return $stamp;
    }
    


    public function getRelatedStamps(int $excludeId, int $limit = 4): array
    {
        $sql = "SELECT s.id, s.name, i.image_url
                FROM Stamp s
                LEFT JOIN Image i ON s.id = i.Stamp_id
                WHERE s.id != :excludeId AND i.image_type = 'Main'
                ORDER BY RAND()
                LIMIT :limit";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    
}
