<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Form {
    
    public function processPostData($data): string {
        
        $this->processPost($data);
        return Response::send();
    }
}