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

create table Rating(
    uid INTEGER,
    date_rated DATE,
    price INTEGER,
    food INTEGER,
    mood INTEGER,
    staff INTEGER,
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

 create table Refers(
    uid INTEGER,
    date DATE,
    mid INTEGER,
    PRIMARY KEY(uid,date,mid),
    FOREIGN KEY(uid,date) REFERENCES Rating,
    FOREIGN KEY(mid) REFERENCES MenuItem
);

create table RatingItem(
    uid INTEGER,
    date DATE,
    mid INTEGER,
    rating INTEGER,
    comment VARCHAR(200),
    PRIMARY KEY (uid,date,mid),
    FOREIGN KEY (uid) REFERENCES Person,
    FOREIGN KEY (mid) REFERENCES MenuItem,
    constraint rating_range
        check(rating>=1 AND rating<=5)
);
