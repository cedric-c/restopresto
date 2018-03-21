<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Restaurant extends Model {

    const PRIMARY_KEY = 'rid';

    public function getPK(): string {
        return self::PRIMARY_KEY;
    }

    public function __construct(){}
        
    public function insert(int $id, string $name, string $type, string $url): int{
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $pk = $this->getPK();
        $query = "insert into $table (rid, name, type, url) values ('$id', '$name', '$type', '$url')";
        return $conn->exec($query);
    }

}