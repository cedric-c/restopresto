<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Location extends Model {

    const PRIMARY_KEY = 'lid';

    public function getPK(): string {
        return PRIMARY_KEY;
    }
    
    public function getManagerAndDate (String $value): array{
        $conn = Connection::init()->getConnection();
        $q  = "select P.name, L.opened";
        $q .= "from restaurant as Re, location as L, person as P";
        $q .= "where R.type=$value and R.rid=L.rid and P.uid = L.manager";
        $s = $conn->query($q);
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }

    public function __construct(){}



}
