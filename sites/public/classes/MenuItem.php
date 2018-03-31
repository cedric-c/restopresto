<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class MenuItem extends Model {

    const PRIMARY_KEY = 'mid';

    public function getPK(): string {
        return self::PRIMARY_KEY;
    }

    public function insert(int $id, 
                           string $name, 
                           string $type, 
                           string $category, 
                           string $price,
                           string $comment,
                           string $rid): int{
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $query = "INSERT INTO $table (mid, name, type, category, description, price, rid) VALUES ('$id', '$name', '$type', '$category', '$comment', '$price', '$rid')";
        return $conn->exec($query);
    }
    
    public function getMenuByCategory(int $restaurantId): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT * FROM menuitem WHERE rid = '$restaurantId' ORDER BY category";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getMostExpensive(int $restaurantId): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT * FROM menuitem WHERE price= (SELECT max(price) FROM menuitem WHERE rid='$restaurantId') AND rid = '$restaurantId'";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCategories(): array {
      $conn = Connection::init()->getConnection();
      $q    = "SELECT DISTINCT category FROM menuitem";
      $s    = $conn->query($q);
      return $s->fetchAll(PDO::FETCH_COLUMN);
    }
    

    public function __construct(){}

}