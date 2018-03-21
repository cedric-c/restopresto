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
        $table = get_called_class();
        $pk = $this->getPK();
        return $conn->exec("delete from $table where $pk=$id");
    }
    
    public function getNextId(): int {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $pk = $this->getPK();
        $q = "select max($pk) from $table";
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