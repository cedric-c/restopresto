<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Restaurant extends Model {
    private $name;
    private $type;
    private $url;
    
    public function __construct(){}
    
        
    public function getName(): string {
        return $this->name;
    }
        
    public function getType(): string {
        return $this->type;
    }
    
    public function getURL(): string {
        return $this->url;
    }
            
    public function setName(string $v): void {
        return $this->name = $v;
    }
        
    public function setType(string $v): void {
        return $this->type = $v;
    }
    
    public function setURL(string $v): void {
        return $this->url = $v;
    }
    
    public function getData(): array {
        $ret = [
            "rid"       => $this->getId(),
            "name"      => $this->getName(),
            "type"      => $this->getType(),
            "url"       => $this->getURL()
        ];
        return $ret;
    }
}