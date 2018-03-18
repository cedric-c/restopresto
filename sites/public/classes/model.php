<?php
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