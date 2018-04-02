<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class Rating extends Model {

    const PK1 = 'uid';
    const PK2 = 'date_rated';

    public function getPK(): array {
        return [PK1, PK2];
    }
    
    public function __construct(){}

    public function insert(int $userId,
                           string $date_rated,
                           float $price,
                           float $food,
                           float $mood,
                           float $staff,
                           string $comment,
                           int $restaurantId): int {
        
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        
        $q     = "INSERT INTO $table (uid,date_rated,price,food,mood,staff,comment,rid) VALUES ('$userId', '$date_rated', '$price', '$food', '$mood', '$staff', '$comment', '$restaurantId')";
        return $conn->exec($q);
    }
        
    // bad design... don't call get for this class did not think of multi-valued PK tuples...
    public function _get(int $userId, string $date_rated, bool $serialized = true): array {
        $conn = Connection::init()->getConnection();
        $table = get_called_class();
        $k1 = self::PK1;
        $k2 = self::PK2;
        $s = $conn->query("SELECT r.uid, r.date_rated, r.price, r.food, r.mood, r.staff, r.comment, r.rid, p.name FROM $table r, person p WHERE (r.$k1=$userId AND r.$k1=p.uid AND $k2='$date_rated')");
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getNamedRatings(int $restaurantId): array {
      $conn = Connection::init()->getConnection();
      $table = get_called_class();
      $s = $conn->query("SELECT p.name as name, r.date_rated, r.uid, r.price, r.food, r.mood, r.staff, r.comment, r.rid from rating r, person p where r.rid='$restaurantId' and p.uid=r.uid");
      return $s->fetchAll(PDO::FETCH_ASSOC);
    }
  // Query N
  public function ratersBelowAllJohns(): array {
      $conn = Connection::init()->getConnection();
      $q    = "SELECT P.name,P.email
               FROM Rating AS R, Person AS P, Restaurant AS Res 
               WHERE R.uid=P.uid AND Res.rid=R.rid
               GROUP BY P.name,P.email
               HAVING sum(R.price +R.food +R.mood+ R.staff)
               <(SELECT sum(R1.price +R1.food +R1.mood+ R1.staff)
                FROM Rating AS R1 INNER JOIN Person AS P1 ON (R1.uid=P1.uid)
                WHERE P1.name LIKE 'John%')";
      $s    = $conn->query($q);
      return $s->fetchAll(PDO::FETCH_ASSOC);
  }
  //Query O
  public function mostDiverseRaters(): array {
    $conn = Connection::init()->getConnection();
    $q    = "SELECT P.name as pname, P.type, P.email, Res.name as rname, Ra.price, Ra.food, Ra.mood, Ra.staff, 
             MAX(RatingsApart) AS HighestApart
             FROM Person AS P,Rating AS Ra,Restaurant AS Res,
             (SELECT P1.uid AS PersonId,P1.type AS Type, 
             (MAX(R.price +R.food +R.mood+ R.staff) - MIN(R.price +R.food +R.mood+ R.staff)) AS RatingsApart
             FROM Rating R
             INNER JOIN Person AS P1 ON (P1.uid = R.uid) 
             INNER JOIN Restaurant AS Re ON (Re.rid =R.rid)
             GROUP BY P1.uid, P1.type) AS Personsdata
             WHERE P.uid=PersonId AND Ra.uid=P.uid AND Res.rid=Ra.rid
             GROUP BY P.name,P.type, P.email, Res.name, Ra.comment, Ra.price, Ra.food, Ra.mood, Ra.staff
             ORDER BY HighestApart DESC";
    $s    = $conn->query($q);
    return $s->fetchAll(PDO::FETCH_ASSOC);
  }

  //QUERY K
  public function highestOverallRaters():array{
    $conn = Connection::init()->getConnection();
    $q    = "SELECT Pe.name,Pe.joined, Pe.reputation, Re.name, R.date_rated
             FROM Rating AS R, Person AS Pe, Restaurant AS Re
             WHERE Pe.uid IN (SELECT P1.uid
             FROM Person AS P1
             GROUP BY P1.uid
             HAVING (SELECT AVG(ra.mood + ra.food)
             FROM Rating as Ra
             WHERE Ra.uid=P1.uid)>= All(SELECT avg(Rat.mood +Rat.food)
                          FROM Rating AS Rat, person AS p2
                          WHERE Rat.uid = p2.uid
                          GROUP BY p2.uid))
            AND R.uid = Pe.uid AND R.rid = Re.rid";
    $s    = $conn->query($q);
    return $s->fetchAll(PDO::FETCH_ASSOC);
  }

}
