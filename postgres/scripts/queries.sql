--f-Number of times a person has rated for all the restaurants they have rated
select P.name,Re.name, count(*)
from Restaurant as Re, rating as R, person as P
where P.uid=R.uid and R.rid= Re.rid
GROUP BY P.name, Re.name;

--g-restuarants that has not been rated in january in 2015
select Re.rid, Re.url, Re.name, L.phone, Re.type 
from restaurant as Re, location as L, rating as R
where Re.rid=L.rid and Re.rid not in (select Res.rid
						FROM restaurant as Res, rating as Ra
						WHERE Res.rid =Ra.rid and extract(year from Ra.date_rated) = 2015  AND extract(month from Ra.date_rated)  = 1
						group by Res.rid)
Group by Re.rid, Re.url, Re.name,L.phone, Re.type; 

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

-- [ ] i) List the details of the Type Y restaurants that obtained the highest Food rating. Display the restaurant name together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.)
-- Get the highest food rating for some type of restaurant (type Y, could be anything) list the restaurant name along with the raters name.
select max(f_sum)
from 
(select Re.rid, sum(R.food) as f_sum
	from restaurant as Re, rating AS R
	where Re.rid=R.rid
	GROUP BY Re.rid) as sum;

-- [ ] k) Find the names, join‐date and reputations of the raters that give the highest overall rating, in terms of the Food and the Mood of restaurants. Display this information together with the names of the restaurant and the dates the ratings were done.
-- For each restaurant, find the person which rated the restaurant the highest in terms of Food and Mood. 
-- there should be only 1 record returned per restaurant.
select P.name,P.uid ,P.joined, P.reputation, Re.name, R.date_rated
from person As P, restaurant as Re, rating as R
where P.uid=R.uid and R.rid = Re.rid and R.food > (select avg (R.food) 
													from rating As R) and R.mood >(select avg (R.mood) 
																					from rating AS R);
select count(*)
from rating;
