<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Restaurant extends Model {

    const PRIMARY_KEY = 'rid';
    
    private $loaded = false;
    
    public function getPK(): string {
        return self::PRIMARY_KEY;
    }
    
    public function isLoaded(): bool {
        return $this->loaded;
    }

    public function __construct(int $id = null){
        if($id != null){
            $this->loaded = true;
            $this->setId($id);
        }
    }
        
    public function insert(int $id, string $name, string $type, string $url): int{
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $pk = $this->getPK();
        $query = "insert into $table (rid, name, type, url) values ('$id', '$name', '$type', '$url')";
        return $conn->exec($query);
    }

    public function getUnrated(): array {
        $conn = Connection::init()->getConnection();
        $q  = "SELECT Re.rid, Re.url, Re.name, L.phone, Re.type FROM restaurant as Re, location as L, rating as R WHERE Re.rid=L.rid AND Re.rid NOT IN (SELECT Res.rid FROM restaurant as Res, rating as Ra WHERE Res.rid=Ra.rid AND EXTRACT(year FROM Ra.date_rated) = 2015 AND EXTRACT(month from Ra.date_rated) = 1 GROUP BY Res.rid) GROUP BY Re.rid, Re.url, Re.name, L.phone, Re.type";
        $s = $conn->query($q);
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
    public function jsonSerialize(): string {
        if($this->isLoaded())
            $data = $this->get($this->getId());
        else
            $data = $this->getAll();
        
        return json_encode($data);
    }
    
    public function getAll(): array{
        return $this->getAllWithNumber();
    }
    
    public function getAllWithNumber(): array {
        $conn = Connection::init()->getConnection();
        $q  = "select R.rid, R.url, R.name, R.type, L.phone FROM restaurant as R left join location as L ON R.rid=L.rid";
        $s  = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

}