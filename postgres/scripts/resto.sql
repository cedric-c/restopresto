/**
 * @author Dilanga Algama <...@uottawa.ca>
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Dilanga Algama, Cédric Clément.
 */
 
create schema restopresto;
set search_path = "restopresto";
alter role postgres set search_path to "restopresto";
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
    password VARCHAR(100),
    name VARCHAR(100),
    joined DATE,
    type VARCHAR(100),
    reputation NUMERIC(3,2) DEFAULT 1,
    PRIMARY KEY (uid),
    CONSTRAINT unique_email UNIQUE(email),
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
    FOREIGN KEY (rid) REFERENCES Restaurant ON DELETE CASCADE
);


-- for restaurant
create table Rating(
    uid INTEGER,

    date_rated TIMESTAMP,
    price NUMERIC(3,2), -- #.##
    food NUMERIC(3,2),
    mood NUMERIC(3,2),
    staff NUMERIC(3,2),
    comment VARCHAR(200),
    rid INTEGER,
    PRIMARY KEY (uid,date_rated),
    FOREIGN KEY (uid) REFERENCES Person,
    FOREIGN KEY (rid) REFERENCES Restaurant ON DELETE CASCADE,
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
    FOREIGN KEY (rid) REFERENCES Restaurant ON DELETE CASCADE
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

-- for menu items
create table RatingItem(
    uid INTEGER,
    date_rated TIMESTAMP,
    mid INTEGER,
    rating NUMERIC(3,2),
    comment VARCHAR(200),
    PRIMARY KEY (uid,date_rated,mid),
    FOREIGN KEY (uid,date_rated) REFERENCES Rating ON DELETE CASCADE,
    FOREIGN KEY (mid) REFERENCES MenuItem ON DELETE CASCADE,
    constraint rating_range
        check(rating>=1 AND rating<=5)
);


INSERT INTO Restaurant (rid,name,type,url)
    Values(100000,'Soul Stone Sushi','Chinese','https://www.soulstoneoriginal.com/?utm_medium=referral&utm_source=tripadvisor'),
          (100100,'La Bottega','Italian','https://www.labottega.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100200,'Atelier','Canadian','http://www.atelierrestaurant.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100300,'Kochin Kitchen','Indian','http://www.kochinkitchen.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100400,'El Camino','Mexican','http://eatelcamino.com/?utm_source=tripadvisor&utm_medium=referral'),
          (100500,'Thai Flame Restaurant','Thai','http://www.thai-flame.ca/?utm_source=tripadvisor&utm_medium=referral'),

          (100600,'The Keg Steakhouse & Bar','American','https://www.kegsteakhouse.com/locations/hunt-club-keg/?utm_source=tripadvisor&utm_medium=referral'),
          (100700,'Absinthe','French','http://www.absinthecafe.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (100800,'Restaurant E18hteen','Canadian','http://www.restaurant18.com/?utm_source=tripadvisor&utm_medium=referral'),
          (100900,'Chez Fatima','Middle Eastern','http://www.chezfatima.ca/?utm_source=tripadvisor&utm_medium=referral'),
          (101000,'Mandarin Restaurant','Chinese','https://mandarinrestaurant.com/'),
          (101100,'Ceylonta Restaurant','Sri Lankan','http://www.ceylonta.com/en/?utm_source=tripadvisor&utm_medium=referral');

        
INSERT INTO PERSON(uid,email,password,name,joined,type,reputation)
    Values(678000,'DameJ@gmail.com','Dame1234','Dame Julie Andrews','2001-10-05','Online',2.4),
          (678001,'Angel@hotmail.com','Qwerty123','Vanessa Angel','2007-09-24','Blog',5),
          (678002,'GAnwar@gmail.com','Anwar_1965','Gabrielle Anwar','2009-08-03','Foodcritic',4.2),
          (678003,'Richard.Armitage@microsoft.com','RichOttawa','Richard Armitage','2003-06-30','Online',2.5),
          (678004,'Gemma190@hotmail.com','Blah190','Gemma Arterton ','2008-04-08','Blog',3.6),
          (678005,'Tom.Baker@microsoft.com','BakeryMan','Tom Baker','2002-04-05','Online',3.7),
          (678006,'Bale@gmail.com','ChristianBE','Christian Bale','2003-09-15','Online',2.6),
          (678007,'John289@hotmail.com','Barnes289','John Barnes','2017-05-09','Foodcritic',1.9),
          (678008,'Sacha097@uottawa.ca','Cohen097','Sacha Baron Cohen','2018-08-03','Blog',1.2),
          (678009,'BartonMis@gmail.com','Barton.678','Mischa Barton','2005-04-07','Foodcritic',4.3),
        
          (678010,'SGuillory@hotmail.com','Restaurant101','Sienna Guillory','2009-05-02','Online',3.6),
          (678011,'Parkerc@gmail.com','Lovinit','Cecil Parker','2017-12-24','Blog',4.2),
          (678012,'Bloom101@gmail.com','BloomBoy','Orlando Bloom','2007-03-28','Blog',2.8),
          (678013,'Stanley2988@hotmail.com','Holloway2988','Stanley Holloway','2004-07-27','Online',3.2),
          (678014,'Helena@gmail.com','Carter12345','Helena Bonham Carter','2009-04-10','Foodcritic',1.5),
          (678015,'Natasha.richardson@microsoft.com','NatashaRich','Natasha Richardson ','2013-11-30','Online',4.8);

INSERT INTO Location (lid,opened,manager,phone,address,hour_start,hour_end,rid)
    Values(1980000,'2009-09-07',678009,'613-445-9807','2701 St. Joseph Blvd, Ottawa, Ontario K1C 1G4, Canada','16:00','23:00',100000),
          (1980010,'2017-09-08',678006,'613-509-7865','64 George St, Ottawa, Ontario K1N 5V9, Canada','8:00','20:00',100100),
          (1980020,'2008-09-08',678002,'873-456-7945','540 Rochester St, Ottawa, Ontario K1S 4M1, Canada','10:00','21:30',100200),
          (1980030,'2012-09-04',678000,'814-765-9087','271 Dalhousie St | Corner of Dalhousie Street and Murray Street, Ottawa, Ontario K1N 7E5, Canada','9:00','22:00',100300),
          (1980040,'2013-03-02',678007,'641-890-4327','380 Elgin St, Ottawa, Ontario K2P 1N1, Canada','10:00','20:00',100400),
          (1980050,'2000-05-29',678001,'613-789-4657','1902 Robertson Rd Suite 104, Ottawa, Ontario K2H 5B8, Canada','14:00','23:59',100500),
          (1980060,'2011-05-15',678008,'613-248-0509','376 Hunt Club Rd, Ottawa, Ontario K1V 1C1, Canada','4:30','23:00',100600),
          (1980070,'2006-02-01',678003,'613-761-1138','1208 Wellington Street West Ottawa, Ontario','23:30','22:00',100700),
          (1980080,'2008-04-02',678004,'613-890-5643','18 York St, Ottawa, Ontario K1N 5S6, Canada','4:00','23:30',100800),
          (1980090,'2009-12-20',678005,'819-771-7568','125 Promenade Du Portage, Gatineau, Quebec J8X 2K2, Canada','14:30','22:00',100900),
          (1980100,'2015-08-24',678010,'613-834-7000','2055 Tenth Line Rd, Ottawa, Ontario K4A 4C5, Canada','10:00','22:00',101000),
          (1980110,'2003-07-21',678011,'613-828-7812','2920 Carling Ave, Ottawa, Ontario K2B 7J7, Canada','11:30','14:00',101100);


INSERT INTO Rating (uid,date_rated,price,food,mood,staff,comment,rid)
    Values(678003,'2017-06-25 00:00:00',2.5,4,4,3,'Needs improvement in customer service',100000),
        (678001,'2003-09-08 00:00:00',3.6,4.6,5,4.5,'Great servers',100000),
        (678005,'2016-03-13 00:00:00',4,3.5,2.5,3.5,'Staff is very friendly',100000),
        (678012,'2008-03-08 00:00:00',1.5,1,2.5,4.8,'Keep it up',100000),
        (678006,'2010-03-07 00:00:00',2.3,4.4,5,4,'Price is to high.',100000),
        (678001,'2005-02-08 00:00:00',3.4,4.5,2.5,2.9,'staff could be more helpful.',100000),
        (678003,'2012-04-20 00:00:00',5,5,5,4.5,NULL,100000),
        (678011,'2001-08-04 00:00:00',5,4,3.4,3,'Cheers',100000),
        (678003,'2017-06-27 00:00:00',2.5,4,4,3,'Price were to expensive and staff services needs improvement',100100),
        (678001,'2003-09-23 00:00:00',3.6,4.6,5,4.5,'Cheers',100100),
        (678005,'2016-03-29 00:00:00',4,3.5,2.5,3.5,'Staff is very friendly',100100),
        (678012,'2008-03-05 00:00:00',1.5,1,2.5,4.8,NULL,100100),
        (678006,'2010-03-06 00:00:00',2.3,4.4,5,4,'Price is to high.',100100),
        (678001,'2005-02-03 00:00:00',3.4,4.5,2.5,2.9,'staff could be more helpful.',100100),
        (678003,'2012-04-18 00:00:00',5,5,5,4.5,NULL,100100),
        (678011,'2001-08-02 00:00:00',5,4,3.4,3,'Cheers',100100),
        (678004,'2006-09-15 00:00:00',1,3.5,2,2,'Needs improvement in customer service.',100200),
        (678002,'2017-12-24 00:00:00',4,4,5,4.5,'We had an amazing time.Thank you.',100200),
        (678001,'2006-09-15 00:00:00',3.5,4,4,4,'Pricy',100200),
        (678000,'2015-03-15 00:00:00',4.5,3,4.5,5,'Thank you',100200),
        (678014,'2014-02-02 00:00:00',3.5,4.2,4.1,3,NULL,100200),
        (678007,'2009-01-29 00:00:00',5,5,5,5,NULL,100200),
        (678009,'2004-05-23 00:00:00',2.5,2.5,3,3,'Thanks',100200),
        (678001,'2007-09-09 00:00:00',4,4,4,4,'Cheers',100200),
        (678003,'2018-01-29 00:00:00',2.5,2,4,3.5,'Prices should be looked into.',100300),
        (678014,'2016-03-21 00:00:00',3.5,4,4,4,'Thank you',100300),
        (678005,'2011-03-28 00:00:00',5,5,5,3,'Cheers',100300),
        (678010,'2013-04-16 00:00:00',2,2,2,2,NULL,100300),
        (678006,'2017-03-05 00:00:00',1,1,1.5,1,'Great servers',100300),
        (678012,'2015-03-15 00:00:00',2,2,2.5,2,NULL,100300),
        (678003,'2015-03-23 00:00:00',3.5,4.5,2.6,1.5,'Had a good time.',100300),
        (678009,'2016-09-09 00:00:00',3,4,4,2,'Amazing experience',100300),
        (678005,'2004-07-05 00:00:00',4,4,4,5,'Great Service. Will visit again.',100400),
        (678001,'2018-02-03 00:00:00',3,3,2,2,'Keep it up',100400),
        (678001,'2015-03-23 00:00:00',5,5,4.5,5,'Had a great time.',100400),
        (678010,'2016-03-20 00:00:00',5,5,5,5,NULL,100400),
        (678007,'2001-08-02 00:00:00',3.5,2.5,4,4,'Food taste funny',100400),
        (678006,'2009-03-06 00:00:00',2,5,5,5,'Pricy',100400),
        (678001,'2017-12-24 00:00:00',1,2,3,3,'Prices are to high.',100400),
        (678001,'2015-03-27 00:00:00',2,2,2.5,2,NULL,100400),
        (678008,'2008-04-06 00:00:00',3.5,3,4.5,3,NULL,100500),
        (678014,'2016-03-20 00:00:00',3,3,3,3,'Keep it up',100500),
        (678001,'2017-03-04 00:00:00',4,4,4,4,'Cheers',100500),
        (678006,'2017-03-04 00:00:00',3,3,3,3,NULL,100500),
        (678010,'2016-09-09 00:00:00',2.4,2.5,2.5,2.5,'Needs improvements in all the major fields',100500),
        (678008,'2015-03-23 00:00:00',3,3,4.5,3,'Server was very helpful.',100500),
        (678001,'2013-07-02 00:00:00',5,5,5,5,'very comforting environment',100500),
        (678005,'2002-08-27 00:00:00',3,3,4.5,5,'Some dishes were expensive.',100500),
        (678005,'2015-01-25 00:00:00',2,2,2,2,'Disappointing service',100600),
        (678012,'2008-04-06 00:00:00',2.5,3.5,3.5,3.5,'-',100600),
        (678001,'2011-03-28 00:00:00',2,2,2,2,'Could be better',100600),
        (678002,'2018-01-29 00:00:00',4,4,4,4,'Had a great time.',100600),
        (678003,'2003-05-09 00:00:00',3,3.5,2,5,'Server was very helpful.',100600),
        (678004,'2000-09-08 00:00:00',4.5,4.5,3.5,2,'Needs improvements in all the major fields',100600),
        (678006,'2004-07-04 00:00:00',1,1,2,1,NULL,100600),
        (678007,'2013-04-16 00:00:00',2,2,2,1,'Falling apart',100600),
        (678008,'2018-01-28 00:00:00',1,1,3,3,'price are too expensive',100700),
        (678009,'2011-03-28 00:00:00',4,3,1,1,'Need more selection',100700),
        (678010,'2017-12-24 00:00:00',4,4,4,4,'-',100700),
        (678011,'2006-08-14 00:00:00',1,1,1,1,'far from perfect',100700),
        (678012,'2004-07-05 00:00:00',2,3,4,5,NULL,100700),
        (678013,'2007-04-06 00:00:00',5,5,5,5,'no comment',100700),
        (678014,'2007-09-08 00:00:00',1,5,4,2,'Thank you',100700),
        (678015,'2008-04-06 00:00:00',1,3,4,2,'Food taste funny',100700),
        (678005,'2017-12-25 00:00:00',3.5,4,4,4,'Amazing experience',100800),
        (678005,'2009-01-11 00:00:00',3,2.5,2.5,3,'Thanks',100800),
        (678004,'2005-05-05 00:00:00',1,3,3,3,'pricy',100800),
        (678004,'2013-04-16 00:00:00',5,1,3,2,'Thanks',100800),
        (678006,'2008-03-01 00:00:00',4,3,4,3,NULL,100800),
        (678009,'2015-01-25 00:00:00',1,2,1,1,'bad experience',100800),
        (678003,'2011-03-20 00:00:00',1.5,1.5,1.5,1.5,'Food taste funny',100800),
        (678011,'2009-01-29 00:00:00',2.5,2.5,2.5,2.5,'Too much salt in the food',100800),
        (678013,'2018-03-20 00:00:00',4.5,4.5,4.5,4.5,'Too much salt in the food',100900),
        (678015,'2013-04-16 00:00:00',3,3,3,3,NULL,100900),
        (678015,'2011-03-06 00:00:00',2,2,2,4,'Needs improvements in all the major fields',100900),
        (678015,'2017-12-27 00:00:00',3,3,3,2,'Need more selection',100900),
        (678004,'2018-01-19 00:00:00',5,5,4,3,'Too much salt in the food',100900),
        (678003,'2008-04-06 00:00:00',1,3,4,2,'Prices are to high',100900),
        (678002,'2018-02-01 00:00:00',4,5,3.5,4,'Server was very helpful.',100900),
        (678001,'2017-09-04 00:00:00',4,3,2,2,'Too much salt in the food',100900),
        (678000,'2011-03-12 00:00:00',4,5,2,3,NULL,100900),
        (678000,'2013-04-16 00:00:00',3,2,1,1,'Need more selection',101000),
        (678000,'2003-09-09 00:00:00',2,2,5,5,'-',101000),
        (678000,'2004-07-25 00:00:00',5,4,5,4,'Prices are to high',101000),
        (678008,'2008-07-03 00:00:00',3.5,2.5,2.5,2.5,'Too much salt in the food',101000),
        (678008,'2015-01-25 00:00:00',2,2,2,1,'Thank you',101000),
        (678005,'2011-11-11 00:00:00',4,3,4,3,'Thanks',101000),
        (678007,'2009-01-22 00:00:00',4,5,4,5,NULL,101000),
        (678007,'2018-12-29 00:00:00',3,4,2,5,'Need more selection',101000),
        (678008,'2012-11-13 00:00:00',5,5,5,5,'Server was very helpful.',101100),
        (678009,'2017-12-20 00:00:00',2,3,5,4,'Too much salt in the food',101100),
        (678009,'2013-12-13 00:00:00',1,3,4,2,NULL,101100),
        (678013,'2014-12-19 00:00:00',5,1,1,5,'Thanks',101100),
        (678012,'2016-09-09 00:00:00',5,4,5,5,'Cheers',101100),
        (678012,'2009-01-15 00:00:00',4,4,3,2,'Thank you',101100),
        (678010,'2007-08-28 00:00:00',2,1,2,1,'far from perfect',101100),
        (678001,'2017-12-02 00:00:00',4,4,4,3,'Needs improvements in all the major fields',101100);
    
INSERT INTO MenuItem (mid,name,type,category,description,price,rid)
    Values(369101,'Tom Yum Goong','food','Starter','Hot and sour shrimp soup with lemongrass, fresh mushrooms and baby corn.',5.50,100500),
          (369102,'Gaeng Keaw Warn','food','Main','Traditional green curry with bamboo shoots, mixed vegetables, and coconut milk topped with Thai eggplant.',11.00,100500),
          (369103,'Coconut Juice','Beverage','Desert','Plain cocunut juice.',3.50,100500),
          (369104,'Tacos','Food','Starter','Tacos with special taco sauce.',3.50,100400),
          (369105,'Jameson','Beverage','Starter','Bottle of Jamesome 750ml.',3.00,100400),
          (369106,'Tallboys','Beverage','Alcoholic Beverage','3.00',6,100400),
          (369108,'Achar Fish Curry','Food','Main','Spicy Fish curry.',10.99,100300),
          (369107,'Sambar','Food','Starter','Mix of garden vegetables in an aromatic broth.',7.00,100300),
          (369109,'Gulab Jamun','Food','Desert','Pastry balls in rose and sugar syrup.',4.00,100300),
          (369110,'Scallop on Hay','Food','Starter','Garden salad.',6.95,100200),
          (369111,'Tombstone','Food','Main','Lamb meat with a lime dressing.',18.95,100200),
          (369112,'Yam Dragon','Food','Main','Prawn tempered in avacado,cucumber served with sauce on top.',12.95,100000),
          (369113,'Kiss Rolls','Food','Starter','California roll base with spicy mayo and flakes on top.',9.25,100000),
          (369114,'Spicy Chicken','Food','Starter','Chicken with a spicy dressing',9.95,101100),
          (369115,'Tanr','Food','Main','Mutton with vegitables on the side',12.50,101100),
          (369116,'Dobu','Food','Main','Italian bread with ham and cheese',13.45,101000),
          (369117,'Chivas Regal','Beverage','Alcoholic Beverage','Chivas Regal bottle',16.50,101000),
          (369118,'Canadian Beer','Beverage','Alcoholic Beverage','Canadian Beer 1000ml',19.00,101000),
          (369119,'Tommy Beef','Food','Main','Middle eastern style beef with a sweet dressing with vegitables',16.50,100900),
          (369120,'Coca-Cola','Beverage','Soft Drink','Coca-Cola 250ml',4.50,100900),
          (369121,'Bacardi','Beverage','Alcoholic Beverage','Bacardi 750ml',50.00,100800),
          (369122,'Purolla','Food','Main','steamed vegitables with a two dressings ',14.75,100800),
          (369123,'salad','Food','Desert','Caesar salad',22.00,100800),
          (369124,'Soda','Beverage','Soft Drink','Soda 250ml',3.50,100700),
          (369125,'Jonny Walker','Beverage','Alcoholic Beverage','Jonney walker 750ml',35.00,100600),
          (369126,'Salsa','Food','Desert','Chips with a salse sause',4.50,100600),
          (369127,'Steak ribs','Food','Desert','Beef Ribs',24.50,100600),
          (369128,'Coors Beer','Beverage','Alcoholic Beverage','Coors Beer 750ml',6.50,100600),
          (369129,'Tuna Dash','Food','Main','Tuna BBQ style',17.75,101100),
          (369130,'Dew','Beverage','Soft Drink','Dew 250 ml',4.50,101100),
          (369131,'Torillas','Food','Main','Torillas with steamed beef and vegitables',13.00,100900),
          (369132,'Dragon Fish','Food','Main','Dragon fish from the Pacific',15.00,100900),
          (369133,'Fanta','Beverage','Soft Drink','Fanta 250ml',3.50,100800),
          (369134,'Fruit salad','Food','Desert','Fruit salad',5.75,100500),
          (369135,'Rose bread','Food','Main','Rose bread from europe with spicy chicken',6.50,100400),
          (369136,'Fried Rice','Food','Main','plain friend rice',8.00,100100),
          (369137,'chicken parmesan','Food','Main','Tomato Sauce,few slices of the mozzarella, salt and pepper,Parmesan and chicken',12.95,100500),
          (369138,'Sprite','Beverage','Soft Drink','Sprite 250ml',3.50,100400),
          (369139,'Lamb leg','Food','Main','Lamb leg 150g',24.95,100600),
          (369140,'Ice cream','Food','Desert','Chocolate,Vanila,Strawberry Ice cream',3.75,100600);

INSERT INTO RatingItem (uid,date_rated,mid,rating,comment)
    Values(678003,'2017-06-27 00:00:00',369102,3.2,'Tasted better the last time I visited'),
          (678008,'2008-04-06 00:00:00',369112,3,'Very good meal but I find a little too expensive'),
          (678005,'2004-07-05 00:00:00',369107,4,'Very good drink'),
          (678004,'2006-09-15 00:00:00',369113,1.5,'Food was very watery and smelt old'),
          (678003,'2008-04-06 00:00:00',369111,3,'Meal was too sweet'),
          (678002,'2017-12-24 00:00:00',369104,5,'Perfect meal'),
          (678003,'2018-01-29 00:00:00',369107,4,'Really like the mixture of vegitables');








