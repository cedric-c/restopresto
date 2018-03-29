<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Response {
    private static $messages = [];
        
    public static function add(string $key, $value): void{
        self::$messages[$key] = $value;
    }
    
    public static function error(Exception $e): void {
        self::add('state', 'error');
        self::add('message', $e->getMessage());
    }
            
    public static function send(): void {
        header('Content-Type: application/json');
        echo json_encode(self::$messages);
    }
    
    
}