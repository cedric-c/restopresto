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
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015  and R1.rid = Re.rid and R.staff< R1.price
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 and R1.rid = Re.rid and R.staff< R1.food 
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 and R1.rid = Re.rid and R.staff< R1.mood 
UNION
select Re.name, L.opened
from restaurant as Re, location as L,rating as R, rating as R1 
where Re.rid=L.rid and Re.rid =R.rid and R1.uid = 678015 and R1.rid = Re.rid and R.staff< R1.staff;

-- [ ] i) List the details of the Type Y restaurants that obtained the highest Food rating. Display the restaurant name together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.)
-- Get the highest food rating for some type of restaurant (type Y, could be anything) list the restaurant name along with the raters name.

select Res.name,Pe.name
from restaurant as Res, Rating as Ra, person as Pe,(select Re.name as Rname, sum(R.food) as f_sum
													from restaurant as Re, rating as R, person as P
													where Re.type='Canadian' and Re.rid=R.rid and P.uid=R.uid
													GROUP BY Re.name
 													order by f_sum desc
 													limit 1) as Sum
where Res.name=Rname and Pe.uid=Ra.uid and Ra.rid=Res.rid 
group by Res.name,Pe.name;


-- [ ] J)
select Re.type, sum(R.price) as price, sum(R.food) as food, sum(mood) as mood, sum(staff) as staff
from Restaurant as Re, rating as R
where Re.rid=R.rid
Group By Re.type
order by price desc, food desc, mood desc, staff desc
limit 1;


-- [ ] k) Find the names, join‐date and reputations of the raters that give the highest overall rating, in terms of the Food and the Mood of restaurants. Display this information together with the names of the restaurant and the dates the ratings were done.
-- For each restaurant, find the person which rated the restaurant the highest in terms of Food and Mood. 
-- there should be only 1 record returned per restaurant.

-- GOOD TO GO
select Pe.name,Pe.joined, Pe.reputation, Re.name, R.date_rated
from Rating as R, Person as Pe, Restaurant as Re
where Pe.uid in (select P1.uid
				from Person as P1
				group by P1.uid
				having (select avg(ra.mood + ra.food)
						from Rating as Ra
						where Ra.uid=P1.uid)>= All(select avg(Rat.mood +Rat.food)
												  from Rating as Rat, person as p2
												  where Rat.uid = p2.uid
												  group by p2.uid))
	  and R.uid = Pe.uid and R.rid = Re.rid;


-- [ ] l) Find the names and reputations of the raters that give the highest overall rating, in terms of the Food or the Mood of restaurants. Display this information together with the names of the restaurant and the dates the ratings were done.
-- Sum up all the rating
select Pe.name,Pe.reputation, Re.name, R.date_rated
from Rating as R, Person as Pe, Restaurant as Re
where Pe.uid in (select P1.uid
				from Person as P1
				group by P1.uid
				having (select avg(ra.mood + ra.food)
						from Rating as Ra
						where Ra.uid=P1.uid)>= All(select avg(Rat.mood +Rat.food)
												  from Rating as Rat, person as p2
												  where Rat.uid = p2.uid
												  group by p2.uid))
			    and R.uid = Pe.uid and R.rid = Re.rid;

-- M)
select P.name,P.reputation,Rat.comment,M.name,M.price, count(*)
from Person as P, Rating as R,RatingItem as Rat, MenuItem as M, (select R1.uid as Rater,count(*) as count
																 from Person as P,Restaurant as Res, Rating as R1
																 where Res.name ='Kochin Kitchen'and P.uid=R1.uid and R1.rid=Res.rid
																 group by R1.uid
																 order by count desc
																 limit 1) as MostFrequent
where R.uid =Rater and P.uid=R.uid and Rat.uid= R.uid and M.mid = Rat.mid and M.rid = R.rid
Group by P.name,P.reputation,Rat.comment,M.name,M.price;
