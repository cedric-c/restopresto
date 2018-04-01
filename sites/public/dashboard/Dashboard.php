<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Dashboard extends App {

    public function getName(): string {
        return 'Dashboard';
    }
    
    public function getDir(): string {
        return 'Dashboard';
    }    
        
    public function getData(): Array {
        $R     = new Restaurant();
        

        
        
        $r = [
            'types'=>$R->getTypes(),
            'exercise_e' => $R->getAverageTypeCategory(),
        ];
        
        return $r;
    }
    
    public function render(): string {
        return '';
    }
}