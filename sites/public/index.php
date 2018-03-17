<?php declare(strict_types=1);
require_once('Core.php');
try {
    $conn = Connection::init()->getConnection();
    $statement = $conn->query('select * from customer');
    $r = $statement->fetchAll();
    echo 'Home App';
    // var_dump($r);
} catch (PDOException $e){
    echo $e;
}
