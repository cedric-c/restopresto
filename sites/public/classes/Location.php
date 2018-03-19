<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Location extends Model {
    private $id;
    private $opened;
    private $manager;
    private $phone;
    private $address;
    private $hour_start;
    private $hour_end;
    private $rid;
    
    public function __construct(){}
    
    public function getId(): int {
        return $this->id;
    }
    public function setId(int $v): void {
        return $this->id = $v;
    }
        
    public function getOpened(): string {
        return $this->opened;
    }
    public function setOpened(string $v): void {
        return $this->opened = $v;
    }
        
    public function getManager(): int {
        return $this->manager;
    }
    public function setManager(int $v): void {
        return $this->manager = $v;
    }
    
    public function getPhone(): string {
        return $this->phone;
    }
    public function setPhone(string $v): void {
        return $this->phone = $v;
    }
    
    public function getAddress(): string {
        return $this->address;
    }
    public function setAddress(string $v): void {
        return $this->address = $v;
    }

    public function getHoursStart(): string {
        return $this->hoursStart;
    }
    public function setHoursStart(string $v): void {
        return $this->hoursStart = $v;
    }

    public function getHoursEnd(): string {
        return $this->hoursEnd;
    }
    public function setHoursEnd(string $v): void {
        return $this->hoursEnd = $v;
    }

    public function getRestaurantID(): string {
        return $this->hoursEnd;
    }
    public function setRestaurantID(int $v): void {
        return $this->hoursEnd = $v;
    }
    
    public function getData(): array {
        $ret = [
            "lid" => $this->getId(),
            "opened" => $this->getOpened(),
            "manager" => $this->getManager(),
            "phone" => $this->getPhone(),
            "address" => $this->getAddress(),
            "hours_start" => $this->getHoursStart(),
            "hours_end" => $this->getHoursEnd(),
            "rid" => $this->getRestaurantID()
        ];
        return $ret;
    }
    public function jsonSerialize(): string {
        $data = $this->getData();
        return json_encode($data);
    }    
}
