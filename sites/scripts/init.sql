create schema test;
set search_path = "test";
create table Artist(AName VARCHAR(20),Birthplace VARCHAR(20),Style VARCHAR(20),DateOfBirth DATE, PRIMARY KEY (AName));
create table Artwork(
    Title VARCHAR(20),
    Year INTEGER,
    Type VARCHAR(20),
    Price NUMERIC(8,2),
    AName VARCHAR(20),
    PRIMARY KEY (Title),
    FOREIGN KEY (AName) 
    REFERENCES Artist
);
create table Customer(
    CustId INTEGER,
    Name VARCHAR(20),
    Address VARCHAR(20),
    Amount NUMERIC(8,2),
    PRIMARY KEY (CustId)
);
create table LikeArtist(
    CustId INTEGER,
    AName VARCHAR(20),
    PRIMARY KEY(Aname, CustId),
    FOREIGN KEY (Aname)
    REFERENCES ARTIST,
    FOREIGN KEY (CustId)
    REFERENCES Customer
);

insert into Artist(AName, Birthplace,Style,DateOfBirth) values ('Caravaggio', 'Milan','Baroque','1571-09-28');     
insert into Artist(AName, Birthplace,Style,DateOfBirth) values ('Smith', 'Ottawa','Modern','1977-12-12');
insert into Artist(AName, Birthplace,Style,DateOfBirth) values ('Picasso', 'Malaga','Cubism','1881-10-25');

-- select * from Artist;
-- More Artists:
insert into Customer(CustId, Name, Address, Amount) values (1,'John','Ottawa',8.5);
insert into Customer(CustId, Name, Address, Amount) values (2,'Amy','Orleans',9.0);
insert into Customer(CustId, Name, Address, Amount) values (3,'Peter','Gatineau',6.3);


-- Artwork
insert into Artwork(Title,Year,Type,Price,AName) values ('Blue', 2000,'Modern',10000.00,'Smith');
insert into Artwork(Title,Year,Type,Price,AName) values ('The Cardsharps', 1594,'Baroque',40000.00,'Caravaggio');

alter table artist add column Country VARCHAR(20);
alter table Customer add column Rating NUMERIC;
alter table Customer add constraint rating_range CHECK(
    Rating >= 1 AND
    Rating <= 10
);


insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('Leonardo', 'Florence','Renaissance','04-15-1452','Italy');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('Michelangelo', 'Arezzo','Renaissance','03-06-1475','Italy');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('Josefa', 'Seville','Baroque','09-09-1630','Spain');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('Hans Hofmann', 'Weisenburg','Modern','02-17-1966','Germany');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('John', 'San Francisco','Modern','02-17-1920','USA');


insert into Artwork(Title,Year,Type,Price,AName) values ('Waves', 2000,null,4000.00,'John');
insert into Artwork(Title,Year,Type,Price,AName) values ('Three Musicians', 1921,'Modern',11000.00,'Picasso');

insert into LikeArtist(CustId, AName) values (1, 'Picasso');
insert into LikeArtist(CustId, AName) values (2, 'Picasso');
insert into LikeArtist(CustId, AName) values (2, 'Leonardo');
    