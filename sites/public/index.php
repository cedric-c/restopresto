<?php
require_once('Model.php');
require_once('Connection.php');
try {
    $conn = Connection::init()->getConnection();
    $statement = $conn->query('select * from customer');
    $r = $statement->fetchAll();
    var_dump($r);
} catch (PDOException $e){
    echo $e->getMessage();
}
