<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ViewArtist extends View {
    
    public function __construct(Controller $controller, Model $model ) {
        parent::__construct($controller, $model);
    }
        
    // public function render(): string {
        // $name = get_called_class();
        // try{
            // ob_start();
            // include "templates/$name.tpl.php";
            // $page = ob_get_contents();
            // ob_end_clean();
            // return $page;
            // 
        // } catch(Exception $e){
            // return $e;
        // }
    // }
}