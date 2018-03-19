<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('core.php');
try {
    $app = new App();
    $page = new Webpage($app);
    $l = new Location();
    // echo $l;
    echo $page->render();
} catch (Exception $e){
    echo $e;
}
