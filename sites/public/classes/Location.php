<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Location extends Model {
    private $opened;
    private $manager;
    private $phone;
    private $address;
    private $hour_start;
    private $hour_end;
    private $rid;
    
    public function __construct(){}
            
    public function getOpened(): string {
        return $this->opened;
    }
    public function setOpened(string $v): void {
        $this->opened = $v;
    }
        
    public function getManager(): int {
        return $this->manager;
    }
    public function setManager(int $v): void {
        $this->manager = $v;
    }
    
    public function getPhone(): string {
        return $this->phone;
    }
    public function setPhone(string $v): void {
        $this->phone = $v;
    }
    
    public function getAddress(): string {
        return $this->address;
    }
    public function setAddress(string $v): void {
        $this->address = $v;
    }

    public function getHoursStart(): string {
        return $this->hoursStart;
    }
    public function setHoursStart(string $v): void {
        $this->hoursStart = $v;
    }

    public function getHoursEnd(): string {
        return $this->hoursEnd;
    }
    public function setHoursEnd(string $v): void {
        $this->hoursEnd = $v;
    }

    public function getRestaurantID(): string {
        return $this->hoursEnd;
    }
    public function setRestaurantID(int $v): void {
        $this->hoursEnd = $v;
    }
    
    public function getData(): array {
        return [];
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
}
