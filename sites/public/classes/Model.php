<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
abstract class Model implements JsonSerializable {
    
    private $id;
    
    private $loaded = false;
    
    public function __construct(int $id = null){
        if($id != null){
            $this->loaded = true;
            $this->setId($id);
        }
    }
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function isLoaded(): bool {
        return $this->loaded;
    }    
    
    public function getData(): Array {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $statement = $conn->query("select * from $table");
        $r = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
    public function getAll(): Array {
        return $this->getData();
    }

    public function jsonSerialize(): string {
        if($this->isLoaded())
            $data = $this->get($this->getId());
        else
            $data = $this->getAll();
        
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
    
    /**
     * Returns all records which match the value of $v for the attribute $a.
     */
    public function getKeyValue(string $attribute, $value): array {
        if($value == null)
            throw new Exception("Must have an attribute value to compare to. Value cannot be null ($attribute)");
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $s = $conn->query("select * from $table where $attribute='$value'");
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