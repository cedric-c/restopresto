<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Person extends Model {

    const PRIMARY_KEY = 'uid';

    public function getPK(): string {
        return PRIMARY_KEY;
    }

    public function __construct(){}
    
    public function getHighRaters(): array {
        $conn = Connection::init()->getConnection();
        $q  = "select Re.name, L.phone, Re.type";
        $q .= " where Re.rid=L.rid and Re.rid not in (select Res.rid";
        $q .= " FROM restaurant as Res, rating as Ra";
        $q .= " WHERE Res.rid =Ra.rid and extract(year from Ra.date_rated) =";
        $q .= " 2015  AND extract(month from Ra.date_rated)  = 1";
        $q .= " group by Res.rid)";
        $q .= " Group by Re.name,L.phone, Re.type";
        $s = $conn->query($q);
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
    
}