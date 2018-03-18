<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class View implements Renderable {
    private $model;
    private $controller;
    
    public function __construct(Controller $controller, Model $model ) {
        $this->controller   = $controller;
        $this->model        = $model;
    }
    
    public function render(): string {
        try{
            ob_start();
            include 'templates/webpage.html';
            $page = ob_get_contents();
            ob_end_clean();
            return $page;
            
        } catch(Exception $e){
            return $e;
        }
    }
}