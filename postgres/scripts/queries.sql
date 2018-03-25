--f-Number of times a person has rated for all the restaurants they have rated
select P.name,Re.name, count(*)
from Restaurant as Re, rating as R, person as P
where P.uid=R.uid and R.rid= Re.rid
GROUP BY P.name, Re.name;

--g-restuarants that has 
select Re.name, L.phone, Re.type 
from restaurant as Re, location as L, rating as R
where Re.rid=L.rid and Re.rid not in (select Res.rid
						FROM restaurant as Res, rating as Ra
						WHERE Res.rid =Ra.rid and extract(year from Ra.date_rated) = 2015  AND extract(month from Ra.date_rated)  = 1
						group by Res.rid)
Group by Re.name,L.phone, Re.type; 

--h -- 
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 AND R.staff< R1.price
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 AND R.staff< R1.food 
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 AND R.staff< R1.mood 
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 AND R.staff< R1.staff;

--I
select max(f_sum)
from 
(select Re.rid, sum(R.food) as f_sum
	from restaurant as Re, rating AS R
	where Re.rid=R.rid
	GROUP BY Re.rid) as sum;
--k
select P.name,P.uid ,P.joined, P.reputation, Re.name, R.date_rated
from person As P, restaurant as Re, rating as R
where P.uid=R.uid and R.rid = Re.rid and R.food > (select avg (R.food) 
													from rating As R) and R.mood >(select avg (R.mood) 
																					from rating AS R);
select count(*)
from rating;
