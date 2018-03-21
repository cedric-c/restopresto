<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Response {
    private static $messages = [];
        
    public static function add(string $key, array $value): void{
        self::$messages[$key] = $value;
    }
    
    public static function render(): string {
        header('Content-Type: application/json');
        return json_encode(self::$messages);
    }
        
    public static function send(): string {
        return json_encode(self::$messages);
    }
    
    
}