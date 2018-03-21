<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
abstract class Model implements JsonSerializable {
    
    private $id;
    
    public function __construct(){}
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getData(): Array {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $statement = $conn->query("select * from $table");
        $r = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

        
    public function jsonSerialize(): string {
        $data = $this->getData();
        return json_encode($data);
    }
    
    public function delete(int $id): int {
        $conn = Connection::init()->getConnection();
        $table = $this->getTable();
        $pk = $this->getPK();
        return $conn->exec("delete from $table where $pk=$id");
    }
    
    public function get(int $id, bool $serialized = true): array {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $key = $this->getPK();
        $s = $conn->query("select * from $table where $key=$id");
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
    public function getTable(): string {
        return get_called_class();
    }
    
    public function getNextId(): int {
        $conn = Connection::init()->getConnection();
        $pk = $this->getPK();
        $q = "select max($pk) from " . $this->getTable();
        $statement = $conn->query($q);
        $v = $statement->fetchAll(PDO::FETCH_ASSOC);
        $max = (int) $v[0]['max'];
        return $max + 1;
    }
    
    abstract function getPK();
    
    public function __toString(): string {
        return get_called_class(). '@' . $this->jsonSerialize();
    }
}