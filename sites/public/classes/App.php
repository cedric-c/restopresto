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
        
    public function getData(): Array {
        $artist = [
            'index'  => 'artist/index.php',
            'folder' => 'artist',
            'caption'=>'Manage Artists'
        ];
        $testing = [
            'index'  => 'app/index.php',
            'folder' => 'app',
            'caption'=>'Manage Apps'
        ];
        $apps = [$artist, $testing];
        $r = [
            'available_apps' => $apps
        ];
        return $r;
    }
    
    public function render(): string {
        return '<h1>Welcome to RestoPresto!</h1><br> <p>Some available applications:</p><applications-component></applications-component>';
    }
}