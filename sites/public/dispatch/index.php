<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('core.php');
$app    = $_POST['application'];
$data   = $_POST['data'];
$action = $_POST['action'];

if($app == 'restaurant-roaster'){
    $controller = ControllerRestaurantRoaster::getInstance();
    echo $controller->processPost($_POST);
} else if ($app == 'restaurant'){
    $controller = ControllerRestaurant::getInstance();
    echo $controller->processPost($_POST);
    
} else if ($app == 'dashboard'){
    $controller = ControllerDashboard::getInstance();
    echo $controller->processPost($_POST);
}
