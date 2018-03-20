<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Webpage implements Renderable {
    
    /**
     * @var string The application which will be rendered by the webpage.
     */
    private $app;

    /**
     * @var associative array Json encoded data.
     */
    private $data;
    
    public function __construct(App $app) {
        $this->addApp($app);
    }
    
    public function addApp(App $app): void {
        $this->app = $app;
    }
    
    public function getApp(): App {
        return $this->app;
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