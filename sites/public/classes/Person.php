<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Person extends Model {
    private $id;
    private $email;
    private $name;
    private $joined_date;
    private $type;
    private $reputation;
    
    public function __construct(){}
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getEmail(): string {
        return $this->email;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function getJoined(): string {
        return $this->joined_date;
    }
    
    public function getType(): string {
        return $this->type;
    }
    
    public function getRep(): float {
        return $this->reputation;
    }
    
    public function setId(int $v): void {
        return $this->id = $v;
    }
    
    public function setEmail(string $v): void {
        return $this->email = $v;
    }
    
    public function setName(string $v): void {
        return $this->name = $v;
    }
    
    public function setJoined(string $v): void {
        return $this->joined_date = $v;
    }
    
    public function setType(string $v): void {
        return $this->type = $v;
    }
    
    public function setRep(float $v): void {
        return $this->reputation = $v;
    }
    
    public function getData(): array {
        $ret = [
            "uid"       => $this->getId(),
            "email"     => $this->getEmail(),
            "name"      => $this->getName(),
            "joined"    => $this->getJoined(),
            "type"      => $this->getType(),
            "reputation" => $this->getRep()
        ];
        return $ret;
    }
        
    public function jsonSerialize(): string {
        $data = $this->getData();
        return json_encode($data);
    }
    
}