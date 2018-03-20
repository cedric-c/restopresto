<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
abstract class Controller {
    private $model;
    
    public function __construct(Model $model) {
        $this->model = $model;
    }
        
    public function getModel(): Model {
        return $this->model;
    }
    
    /**
     * Return the name of the directory for this application.
     * @return string
     */
    abstract function getAppDir(): string;
    
    /**
     * Return a user-friendly name of the application.
     * @return string
     */
    abstract function getAppName(): string;
}