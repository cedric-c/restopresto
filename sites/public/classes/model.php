<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
abstract class Model implements JsonSerializable {
    
    private $id;
    
    private $_data;
    
    public function __construct(){}
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function getData(): array {
        return $this->_data;
    }
    
    public function setData(array $data): void {
        $this->_data = $data;
    }
    
    abstract public function jsonSerialize(): string;
    
    public function __toString(): string {
        return get_called_class(). '@' . $this->jsonSerialize();
    }
}