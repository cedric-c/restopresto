<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Rating extends Model {
    private $date_rated;
    private $price;
    private $food;
    private $mood;
    private $staff;
    private $comment;
    private $rid;
    
    public function __construct(){}
            
    public function getDateRated(): string {
        return $this->date_rated;
    }
    public function setDateRated(string $v): void {
        return $this->date_rated = $v;
    }
        
    public function getRestaurantID(): string {
        return $this->hoursEnd;
    }
    public function setRestaurantID(int $v): void {
        return $this->hoursEnd = $v;
    }

    public function getPrice(): int {
        return $this->price;
    }
    public function getFood(): int {
        return $this->food;
    }
    public function getMood(): int {
        return $this->mood;
    }
    public function getStaff(): int {
        return $this->staff;
    }
    public function getComment(): string {
        return $this->comment;
    }

    public function setPrice(int $v): void {
        $this->price = $v;
    }
    public function setFood(int $v): void {
        $this->food = $v;
    }
    public function setMood(int $v): void {
        $this->mood = $v;
    }
    public function setStaff(int $v): void {
        $this->staff = $v;
    }
    public function setComment(int $v): void {
        $this->comment = $v;
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
