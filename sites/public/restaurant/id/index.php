<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('core.php');
$mi = new MenuItem();
var_dump($mi->getCategories());
$re = new Restaurant();
echo '<br>', '<br>';
var_dump($re->getTypes());
try {
    $model = new Restaurant( (int) $_GET['id']);
    $controller = ControllerRestaurant::getInstance();
    $view = new ViewRestaurant($controller, $model);
    echo $view->render();
} catch (Exception $e){
    echo $e;
}
