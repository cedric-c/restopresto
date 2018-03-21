<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Artwork extends Model {

    const PRIMARY_KEY = 'title';

    public function getPK(): string {
        return PRIMARY_KEY;
    }


    public function getName(): string {
        return __CLASS__;
    }
            
    public function render(): string {
        return 'Application Rendered<br><br><button type="button" class="btn btn-primary">Action</button>';
    }
}