create schema restopresto;
set search_path = "restopresto";


-- todo: integrity constraints on reputation
create table Restaurant(
    rid INTEGER,
    email VARCHAR(100),
    name VARCHAR(100),
    joined DATE,
    type VARCHAR(100),
    reputation NUMERIC(3,2), 
    PRIMARY KEY (rid)
);

create table Has(
    FOREIGN KEY (rid) REFERENCES Restaurant,    
    FOREIGN KEY (lid) REFERENCES Location
    PRIMARY KEY (rid, lid)
);

create table Location(
    lid INTEGER,
    opened DATE,
    manager VARCHAR(100),
    phone VARCHAR(100),
    address VARCHAR(100),
    hour_start TIME,
    hour_end TIME,
    FOREIGN KEY (rid) REFERENCES Restaurant,    
    PRIMARY KEY (lid)
);

create table Rated();
create table Rating();

create table Serves();
    
-- need IC on price for positive ints or 0
create table MenuItem(
    mid INTEGER,
    name VARCHAR(100),
    type VARCHAR(100), -- this is going to be a relation MenuItemType
    category VARCHAR(100), -- this is going to be a relation MenuItemCategory
    description TEXT,
    price NUMERIC(8,2), -- 999999.00 is the max price
    FOREIGN KEY (rid) REFERENCES Restaurant,
    PRIMARY KEY (mid)
);
create table Refers();

create table Written();
create table User();