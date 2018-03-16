create schema test;
set search_path = "test";

insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('A', 'B','Renaissance','04-15-1452','Italy');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('C', 'D','Renaissance','03-06-1475','Italy');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('E', 'F','Baroque','09-09-1630','Spain');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('F', 'Weisenburg','Modern','02-17-1966','Germany');
insert into Artist(AName, Birthplace,Style,DateOfBirth,Country) values ('G', 'San Francisco','Modern','02-17-1920','USA');
