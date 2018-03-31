<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Person extends Model {

    const PRIMARY_KEY = 'uid';

    public function getPK(): string {
        return PRIMARY_KEY;
    }

    public function __construct(){}
    
}