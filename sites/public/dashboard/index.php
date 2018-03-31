<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('core.php');
try {
    // $model = new Dashboard();
    // $controller = ControllerDashboard::getInstance();
    // $view = new ViewDashboard($controller, $model);
    $app = new Dashboard();
    $view = new Webpage($app);
    $view->setPage('templates/ViewDashboard.tpl.php');
    echo $view->render();
} catch (Exception $e){
    echo $e;
}
