<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class App implements Renderable {

    public function getName(): string {
        return 'RestoPresto';
    }
    
    public function getDir(): string {
        return 'App';
    }
        
    public function getData(): Array {
        $restaurantPage = [
            'index'  => 'restaurant/id/index.php',
            'folder' => 'restaurant',
            'caption'=>'View Restaurant'
        ];
        $restaurant = [
            'index' => 'restaurant/index.php',
            'folder' => 'restaurant',
            'caption' => 'Manage Restaurants'
        ];
        $dashboard = [
            'index' => 'dashboard/index.php',
            'folder'=> 'dashboard',
            'caption'=> 'Dashboard'
        ];
        $person = [
            'index' => 'person/index.php',
            'folder'=> 'person',
            'caption'=> 'Person'
        ];
        $apps = [$restaurantPage, $restaurant, $dashboard, $person];
        $r = [
            'available_apps' => $apps
        ];
        return $r;
    }
    
    public function render(): string {
        return '<h1>Welcome to RestoPresto!</h1><p class=txtb>Some available applications:</p><applications-component></applications-component>';
    }
}