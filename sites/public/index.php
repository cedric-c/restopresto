<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
require_once('Core.php');
try {
    $conn = Connection::init()->getConnection();
    $statement = $conn->query('select * from customer');
    $r = $statement->fetchAll();
    $app = new App();
    $page = new Webpage($app);
    echo $page->render();
} catch (Exception $e){
    echo $e;
}
