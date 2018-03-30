<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Rating extends Model {

    const PK1 = 'uid';
    const PK2 = 'date_rated';

    public function getPK(): array {
        return [PK1, PK2];
    }
    
    public function __construct(){}

    public function insert(int $userId,
                           string $date_rated,
                           float $price,
                           float $food,
                           float $mood,
                           float $staff,
                           string $comment,
                           int $restaurantId): int {
        
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        
        $q     = "INSERT INTO $table (uid,date_rated,price,food,mood,staff,comment,rid) VALUES ('$userId', '$date_rated', '$price', '$food', '$mood', '$staff', '$comment', '$restaurantId')";
        return $conn->exec($q);
    }
        
    // bad design... don't call get for this class did not think of multi-valued PK tuples...
    public function _get(int $userId, string $date_rated, bool $serialized = true): array {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $k1 = self::PK1;
        $k2 = self::PK2;
        $s = $conn->query("SELECT * FROM $table WHERE ($k1=$userId AND $k2='$date_rated')");
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

}
