<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class App implements Renderable {

    public function getName(): string {
        return __CLASS__;
    }
    
    public function getJavascript(): string {
        return 'path/to/javascript';
    }
    
    public function getData(): Array {
        $conn = Connection::init()->getConnection();
        $statement = $conn->query('select * from customer');
        $r = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
    public function render(): string {
        return 'Application Rendered';
    }
}