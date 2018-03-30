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
        $pk = $this->getPK();
        $query = "insert into $table (mid, name, type, category, description, price, rid) values ('$id', '$name', '$type', '$category', '$comment', '$price', '$rid')";
        return $conn->exec($query);
    }

    public function __construct(){}

}