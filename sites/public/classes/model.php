<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Model implements JsonSerializable {
    
    private $id;
    
    public function __construct(){}
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function jsonSerialize(): string {
        $properties = [
            "id" => $this->id
        ];
        return json_encode($properties);
    }
    
    public function __toString(): string {
        return get_called_class(). '@' . $this->jsonSerialize();
    }
}