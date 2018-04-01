<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ViewPerson extends View {
    
    public function __construct(Controller $controller, Model $model ) {
        parent::__construct($controller, $model);
    }
    
    public function _render(): string {
        return 'hello :)';
    }
            
}