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
            'caption'=> 'Dashboard: Statistics'
        ];
        $apps = [$restaurantPage, $restaurant, $dashboard];
        $r = [
            'available_apps' => $apps
        ];
        return $r;
    }
    
    public function render(): string {
        return '';
    }
}