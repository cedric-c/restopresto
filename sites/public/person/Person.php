<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Person extends Model {

    const PRIMARY_KEY = 'uid';

    public function getPK(): string {
        return self::PRIMARY_KEY;
    }
    
    
    public function insert(int $id, string $name, string $email, string $type, string $rep): int{
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $date = date("Y-m-d");
        $query = "INSERT INTO $table (uid, email, name, joined, type, reputation) VALUES ('$id','$email', '$name','$date', '$type', '$rep')";
        return $conn->exec($query);
    }    
        
}