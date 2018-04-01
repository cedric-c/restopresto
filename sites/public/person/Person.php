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
    
    // K)
    public function getHighestFoodAndMood(): array{
        $c = Connection::init()->getConnection();
        $q = "SELECT Pe.name as pname, Pe.joined, Pe.reputation, Re.name as rname, R.date_rated FROM Rating AS R, Person AS Pe, Restaurant AS Re WHERE Pe.uid IN (SELECT P1.uid FROM Person AS P1 GROUP BY  P1.uid HAVING (SELECT avg(ra.mood + ra.food) FROM Rating AS Ra WHERE Ra.uid=P1.uid)>= All (SELECT avg(Rat.mood +Rat.food) FROM Rating AS Rat, person AS p2 WHERE Rat.uid = p2.uid GROUP BY  p2.uid)) AND R.uid = Pe.uid AND R.rid = Re.rid";
        $s = $c->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    // L)
    public function getHighestFoodOrMood(): array{
        $c = Connection::init()->getConnection();
        $q = "SELECT Pe.name as pname, Pe.joined, Pe.reputation, Re.name as rname, R.date_rated FROM Rating AS R, Person AS Pe, Restaurant AS Re WHERE Pe.uid IN (SELECT P1.uid FROM Person AS P1 GROUP BY  P1.uid HAVING (SELECT avg(ra.mood + ra.food) FROM Rating AS Ra WHERE Ra.uid=P1.uid)>= All(SELECT avg(Rat.mood +Rat.food) FROM Rating AS Rat, person AS p2 WHERE Rat.uid = p2.uid GROUP BY  p2.uid)) AND R.uid = Pe.uid AND R.rid = Re.rid";
        $s = $c->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
        
}