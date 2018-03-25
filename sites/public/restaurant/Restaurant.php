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

    public function getUnrated(): array {
        $conn = Connection::init()->getConnection();
        $q  = "select Re.rid, Re.url, Re.name, L.phone, Re.type";
        $q .= " from restaurant as Re, location as L, rating as R";
        $q .= " where Re.rid=L.rid and Re.rid not in (select Res.rid";
        $q .= " FROM restaurant as Res, rating as Ra";
        $q .= " WHERE Res.rid =Ra.rid and extract(year from Ra.date_rated) =";
        $q .= " 2015  AND extract(month from Ra.date_rated)  = 1";
        $q .= " group by Res.rid)";
        $q .= " Group by Re.rid, Re.url, Re.name,L.phone, Re.type";
        $s = $conn->query($q);
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
    public function jsonSerialize(): string {
        $data = $this->getAllWithNumber();
        return json_encode($data);
    }
    
    public function getAll(): array{
        return $this->getAllWithNumber();
    }
    
    public function getAllWithNumber(): array {
        $conn = Connection::init()->getConnection();
        $q  = "SELECT R.rid, R.url, R.name, R.type, L.phone FROM restaurant as R, location as L WHERE R.rid=L.rid";
        $s  = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

}