<?php
require_once('PDOLoader.php');
require_once('Model.php');
$loader = new PDOLoader('../db-config.ini');
var_dump($loader);

$q = 'SELECT * FROM test.artist';
$loader->exec($q);

$model = new Model();
$model->setId(90);
echo $model;

// $dbc = pg_connect("host=postgresql dbname=postgres user=cedric password=frost-marker");
// var_dump($dbc);
// $db = new PDO('pgsql:host=postgresql;dbname=postgres;user=cedric;password=frost-marker');
// var_dump($db);