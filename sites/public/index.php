<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('core.php');
	
try {
	//$model = new Rating();
	//$result= $model->highestOverallRaters();
	//var_dump ($result);

    $app = new App();
    $view = new Webpage($app);
    echo $view->render();
} catch (Exception $e){
    echo $e;
}
