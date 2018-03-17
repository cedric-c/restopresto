<?php declare(strict_types=1);

class App implements Renderable {
    
    public function render(): string {
        return 'Application Rendered';
    }
}