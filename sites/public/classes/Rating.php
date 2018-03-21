<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Rating extends Model {

    const PK1 = 'uid';
    const PK2 = 'date_rated';

    public function getPK(): array {
        return [PK1, PK2];
    }
    
    public function __construct(){}

}
