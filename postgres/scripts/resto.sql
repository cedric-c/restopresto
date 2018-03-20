/**
 * @author Dilanga Algama <...@uottawa.ca>
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Dilanga Algama, Cédric Clément.
 */
 
create schema restopresto;
set search_path = "restopresto";

-- todo: integrity constraints on reputation
create table Restaurant(
    rid INTEGER,
    name VARCHAR(100),
    type VARCHAR(100),
    url VARCHAR(100), 
    PRIMARY KEY (rid)
);

create table Person(          -- represents the rater relation
    uid INTEGER,
    email VARCHAR(100),
    name VARCHAR(100),
    joined DATE,
    type VARCHAR(100),
    reputation NUMERIC(3,2) DEFAULT 1,
    PRIMARY KEY (uid),
    constraint reputation_range
        check(reputation>=1 AND reputation<=5)
);

create table Location(
    lid INTEGER,
    opened DATE,
    manager INTEGER,
    phone VARCHAR(100),
    address VARCHAR(100),
    hour_start TIME,
    hour_end TIME,
    rid INTEGER,
    PRIMARY KEY (lid),
    FOREIGN KEY (manager) REFERENCES Person,
    FOREIGN KEY (rid) REFERENCES Restaurant 
);

create table Rating(
    uid INTEGER,

    date_rated DATE,
    price NUMERIC(3,2),
    food NUMERIC(3,2),
    mood NUMERIC(3,2),
    staff NUMERIC(3,2),
    comment VARCHAR(200),
    rid INTEGER,
    PRIMARY KEY (uid,date_rated),
    FOREIGN KEY (uid) REFERENCES Person,
    FOREIGN KEY (rid) REFERENCES Restaurant,
    constraint price_range
        check(price>=1 AND price<=5),
    constraint food_range
        check(food>=1 AND food<=5),
    constraint mood_range
        check(mood>=1 AND mood<=5),
    constraint staff_range
        check(staff>=1 AND staff<=5)
);
-- need IC on price for positive ints or 0
create table MenuItem(
    mid INTEGER,            --
    name VARCHAR(100),      --
    type VARCHAR(100),      -- TODO this is going to be a relation MenuItemType
    category VARCHAR(100),  -- TODO this is going to be a relation MenuItemCategory
    description TEXT,       -- unlimited in length
    price NUMERIC(8,2),     -- 999999.00 is the max price
    rid INTEGER,
    PRIMARY KEY (mid),
    FOREIGN KEY (rid) REFERENCES Restaurant
);

--redundant to the ratingItem table
-- create table Refers(
--    uid INTEGER,
--    date DATE,
--    mid INTEGER,
--    PRIMARY KEY(uid,date,mid),
--    FOREIGN KEY(uid,date) REFERENCES Rating,
--    FOREIGN KEY(mid) REFERENCES MenuItem
--);

create table RatingItem(
    uid INTEGER,
    date DATE,
    mid INTEGER,
    rating NUMERIC(3,2),
    comment VARCHAR(200),
    PRIMARY KEY (uid,date,mid),
    FOREIGN KEY (uid,date) REFERENCES Rating,
    FOREIGN KEY (mid) REFERENCES MenuItem,
    constraint rating_range
        check(rating>=1 AND rating<=5)
);

INSERT INTO Restaurant (rid,name,type,url)
    Values(100000,'Soul Stone Sushi','Chinese','https://www.soulstoneoriginal.com/?utm_medium=referral&utm_source=tripadvisor'),
          (100100,'La Bottega','Italian','https://www.labottega.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100200,'Atelier','Canadian','http://www.atelierrestaurant.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100300,'Kochin Kitchen','Indian','http://www.kochinkitchen.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100400,'El Camino','Mexican','http://eatelcamino.com/?utm_source=tripadvisor&utm_medium=referral'),
          (100500,'Thai Flame Restaurant','Thai','http://www.thai-flame.ca/?utm_source=tripadvisor&utm_medium=referral');
        
INSERT INTO PERSON(uid,email,name,joined,type,reputation)
    Values(678000,'DameJ@gmail.com','Dame Julie Andrews','2001-10-05','online',2.4),
          (678001,'Angel@hotmail.com','Vanessa Angel','2007-09-24','blog',5),
          (678002,'GAnwar@gmail.com','Gabrielle Anwar','2009-08-03','foodcritic',4.2),
          (678003,'Richard.Armitage@microsoft.com','Richard Armitage','2003-06-30','online',2.5),
          (678004,'Gemma190@hotmail.com','Gemma Arterton ','2008-04-08','blog',3.6),
          (678005,'Tom.Baker@microsoft.com','Tom Baker','2002-04-05','online',3.7),
          (678006,'Bale@gmail.com','Christian Bale','2003-09-15','online',2.6),
          (678007,'Ben289@hotmail.com','Ben Barnes','2017-05-09','foodcritic',1.9),
          (678008,'Cohe097@uottawa.ca','Sacha Baron Cohen','2018-08-03','blog',1.2),
          (678009,'BartonMis@gmail.com','Mischa Barton','2005-04-07','foodcritic',4.3);
        
INSERT INTO Location (lid,opened,manager,phone,address,hour_start,hour_end,rid)
    Values(1980000,'2009-09-07',678009,'613-445-9807','2701 St. Joseph Blvd, Ottawa, Ontario K1C 1G4, Canada','16:00','23:00',100000),
          (1980010,'2017-09-08',678006,'613-509-7865','64 George St, Ottawa, Ontario K1N 5V9, Canada','8:00','20:00',100100),
          (1980020,'2008-09-08',678002,'873-456-7945','540 Rochester St, Ottawa, Ontario K1S 4M1, Canada','10:00','21:30',100200),
          (1980030,'2012-09-04',678000,'814-765-9087','271 Dalhousie St | Corner of Dalhousie Street and Murray Street, Ottawa, Ontario K1N 7E5, Canada','9:00','22:00',100300),
          (1980040,'2013-03-02',678007,'641-890-4327','380 Elgin St, Ottawa, Ontario K2P 1N1, Canada','10:00','20:00',100400),
          (1980050,'2000-05-29',678001,'613-789-4657','1902 Robertson Rd Suite 104, Ottawa, Ontario K2H 5B8, Canada','14:00','23:59',100500);

INSERT INTO Rating (uid,date_rated,price,food,mood,staff,comment,rid)
    Values(678003,'2017-06-27',2.5,4,4,3,'Price were to expensive and staff services needs improvement',100100),
          (678008,'2008-04-06',3.5,3,4.5,3,NULL,100500),
          (678005,'2004-07-05',4,4,4,5,'Great Service. Will visit again.',100400),
          (678004,'2006-09-15',1,3.5,2,2,'Needs improvement in customer service.',100200),
          (678003,'2018-01-29',2.5,2,4,3.5,'Prices should be looked into.',100300),
          (678002,'2017-12-24',4,4,5,4.5,'We had an amazing time.Thank you.',100200);

INSERT INTO MenuItem (mid,name,type,category,description,price,rid)
    Values(369101,'Tom Yum Goong','food','Starter','Hot and sour shrimp soup with lemongrass, fresh mushrooms and baby corn.',5.50,100500),
          (369102,'Gaeng Keaw Warn','food','Main','Traditional green curry with bamboo shoots, mixed vegetables, and coconut milk topped with Thai eggplant.',11.00,100500),
          (369103,'Coconut Juice','Beverage','Desert','Plain cocunut juice.',3.50,100500),
          (369104,'Tacos','Food','starter','Tacos with special taco sauce.',3.50,100400),
          (369105,'Jameson','Beverage','Starter','Bottle of Jamesome 750ml.',3.00,100400),
          (369106,'Tallboys','Beverage','1 Beer Bottle 250ml','3.00',6,100400),
          (369107,'Sambar','Food','Starter','Mix of garden vegetables in an aromatic broth.',7.00,100300),
          (369108,'Achar Fish Curry','Food','Main','Spicy Fish curry.',10.99,100300),
          (369109,'Gulab Jamun','Food','Desert','Pastry balls in rose and sugar syrup.',4.00,100300),
          (369110,'Scallop on Hay','Food','Starter','Garden salad.',6.95,100200),
          (369111,'Tombstone','Food','Main','Lamb meat with a lime dressing.',18.95,100200),
          (369112,'Yam Dragon','Food','Main','Prawn tempered in avacado,cucumber served with sauce on top.',12.95,100000),
          (369113,'Kiss Rolls','Food','Starter','California roll base with spicy mayo and flakes on top.',9.25,100000);


INSERT INTO RatingItem (uid,date,mid,rating,comment)
    Values(678003,'2017-06-27',369102,3.2,'Tasted better the last time I visited'),
          (678008,'2008-04-06',369112,3,'Very good meal but I find a little too expensive'),
          (678005,'2004-07-05',369107,4,'Very good drink'),
          (678004,'2006-09-15',369113,1.5,'Food was very watery and smelt old'),
          (678003,'2018-01-29',369111,3,''),
          (678002,'2017-12-24',369104,5,'Perfect meal');




