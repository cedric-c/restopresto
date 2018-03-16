<?php
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 * 
 * DBC – Database Connection class used to communicated with a database.
 */

class Connection {
    /**
     * Connection object implementing singleton design patter.
     * @var Connection
     */
    private static $connection;
    
    private function __construct(){}
    
    /**
     * Returns a connection object. Makes use of the singleton design pattern in order to only have a single connection object for a user.
     * @return Connection
     */
    public static function init(): Connection {
        if (null === self::$connection){
            self::$connection = new Connection();
        }
        return self::$connection;
    }
    
    /**
     * Returns a PhpDatabaseObject (PDO) which will be used to communicate with the database.
     * @return PDO
     */
    public function getConnection(): PDO {
        $settings = parse_ini_file('../php.ini', true);
        if(!$settings)
            throw new Exception('Error reading db-config');
        $config = $settings['database'];
        
        $username = $config['username'];
        $password = $config['password'];
        $dns = $config['driver'] . ':host=' . $config['host'] . ';';
        if (!empty($config['port']))
            $dns .= 'port=' . $config['port'] . ';';
        $dns .= 'dbname=' . $config['db_name'] . ';';
        
        $pdo = new PDO($dns, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET search_path to ' . $config['schema']);
        return $pdo;
    }
}