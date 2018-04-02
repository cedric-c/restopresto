<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Restaurant extends Model {

    const PRIMARY_KEY = 'rid';
        
    public function getPK(): string {
        return self::PRIMARY_KEY;
    }
        
    public function insert(int $id, string $name, string $type, string $url): int{
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $pk = $this->getPK();
        $query = "INSERT INTO $table (rid, name, type, url) VALUES ('$id', '$name', '$type', '$url')";
        return $conn->exec($query);
    }

    public function getUnrated(): array {
        $conn = Connection::init()->getConnection();
        $q  = "SELECT Re.rid, Re.url, Re.name, L.phone, Re.type FROM restaurant as Re, location as L, rating as R WHERE Re.rid=L.rid AND Re.rid NOT IN (SELECT Res.rid FROM restaurant as Res, rating as Ra WHERE Res.rid=Ra.rid AND EXTRACT(year FROM Ra.date_rated) = 2015 AND EXTRACT(month from Ra.date_rated) = 1 GROUP BY Res.rid) GROUP BY Re.rid, Re.url, Re.name, L.phone, Re.type";
        $s = $conn->query($q);
        $r = $s->fetchAll(PDO::FETCH_ASSOC);
        return $r;
    }
        
    public function getAll(): array{
        return $this->getAllWithNumber();
    }
    
    public function getAllWithNumber(): array {
        $conn = Connection::init()->getConnection();
        $q  = "SELECT R.rid, R.url, R.name, R.type, L.phone FROM restaurant as R left join location as L ON R.rid=L.rid";
        $s  = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAverageTypeCategory(): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT DISTINCT RE.type, (SELECT TRUNC(avg(mi.price), 2) FROM restaurant r, menuitem mi WHERE (r.type=RE.type AND MEI.category=mi.category AND r.rid=mi.rid) GROUP BY r.type, mi.category) AS average, MEI.category FROM restaurant RE, menuitem MEI WHERE (RE.rid=MEI.rid) ORDER BY RE.type";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTypes(): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT DISTINCT type FROM restaurant";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getUserRatingCounts(int $restaurantId): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT P.name, P.uid, count(*) count FROM Restaurant AS Re, rating AS R, person AS P WHERE P.uid=R.uid AND R.rid= Re.rid AND Re.rid=$restaurantId GROUP BY P.name, P.uid ORDER BY count DESC";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    // M) 
    public function getFrequentRaters(int $restaurantId): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT P.name,P.reputation,Rat.comment,M.name,M.price, count(*)
                 FROM Person AS P, Rating AS R,RatingItem AS Rat, MenuItem AS M, 
                 (SELECT R1.uid AS Rater,Res.rid AS Restaurant, count(*) AS count
                 FROM Person AS P,Restaurant AS Res, Rating AS R1
                 WHERE Res.rid =100500 AND P.uid=R1.uid AND R1.rid=Res.rid
                 GROUP BY R1.uid, Res.rid
                 ORDER BY count DESC
                 LIMIT 1) AS MostFrequent
                 WHERE R.uid =Rater AND R.rid=Restaurant AND P.uid=R.uid AND Rat.uid= R.uid AND M.mid = Rat.mid AND M.rid = R.rid
                 GROUP BY R.rid,P.name,P.reputation,Rat.comment,M.name,M.price";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);

    }
    
    // H) 678015
    public function staffRateLowerThanRater(int $raterId): array {
        $conn = Connection::init()->getConnection();
        $q    = "(SELECT Re.name, L.opened as opened,Re.rid
                  FROM restaurant as Re,location as L,rating as R, rating as R1 
                  WHERE Re.rid=L.rid and Re.rid =R.rid and R1.uid = $raterId and R1.rid=Re.rid AND R.staff< R1.price
                  GROUP BY Re.name, L.opened,Re.rid)
                 UNION 
                 (SELECT Re.name, L.opened as opened,Re.rid
                  FROM restaurant as Re, location as L,rating as R, rating as R1 
                  WHERE Re.rid=L.rid and Re.rid =R.rid and R1.uid = $raterId and R1.rid=Re.rid AND R.staff< R1.food 
                  GROUP BY Re.name, L.opened,Re.rid)
                 UNION 
                 (SELECT Re.name, L.opened as opened,Re.rid
                 FROM restaurant as Re, location as L,rating as R, rating as R1
                 WHERE Re.rid=L.rid and Re.rid =R.rid and R1.uid = $raterId and R1.rid=Re.rid AND R.staff< R1.mood 
                 GROUP BY Re.name, L.opened,Re.rid)
                 UNION 
                 (SELECT Re.name, L.opened as opened,Re.rid
                  FROM restaurant as Re, location as L,rating as R, rating as R1
                  WHERE Re.rid=L.rid and Re.rid =R.rid and R1.uid = $raterId and R1.rid=Re.rid AND R.staff< R1.staff
                 GROUP BY Re.name, L.opened,Re.rid)
                 ORDER BY opened desc";

        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    // I) 
    public function highestRatedInType(string $restaurantType): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT Res.name as rname, Pe.name as pname
                 FROM restaurant AS Res, Rating AS Ra, person AS Pe,
                (SELECT Re.name AS Rname, sum(R.food) AS f_sum
                 FROM restaurant AS Re, rating AS R, person AS P
                 WHERE Re.type= '$restaurantType' AND Re.rid=R.rid AND P.uid=R.uid
                 GROUP BY Re.name
                 ORDER BY f_sum desc
                 LIMIT 1) AS Sum
                 WHERE Res.name=Rname AND Pe.uid=Ra.uid AND Ra.rid=Res.rid 
                 GROUP BY Res.name,Pe.name";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    //QUERY J
    public function getMorePopularThanType(string $restaurantType): array {
        $conn = Connection::init()->getConnection();
        $q    = "SELECT Res.type
                 FROM Restaurant AS Res, rating AS Ra
                 WHERE Ra.rid=Res.rid
                 GROUP BY Res.type
                 HAVING sum(Ra.price + Ra.food + Ra.mood + Ra.staff) 
                 >(SELECT sum(R.price + R.food + R.mood + R.staff) 
                   FROM Restaurant AS Re, rating AS R
                   WHERE Re.type ='$restaurantType' AND R.rid = Re.rid)
                   ORDER BY sum(Ra.price + Ra.food + Ra.mood + Ra.staff) DESC";
        $s    = $conn->query($q);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

}