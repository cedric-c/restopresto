## Deliverables

### Question 1 (10 marks)

- [x] ~~1a) Transform the description into a relational model~~
- [x] ~~1b) Create all the tables in POstgreSQL.~~
- [x] ~~1c) Add all other relevant attributes and remember to enforce entity and referential integrity.~~

### Question 2 (10 marks)

- [x] ~~Populate the tables with your own data.~~
- [x] ~~You need 40 different menu items.~~
- [x] ~~You need 12 different restaurants.~~
- [x] ~~Each restaurant has at least 8 ratings each.~~
- [x] ~~You should have at least 15 different raters.~~
- [x] ~~One of the users should have around ratings 10.~~

### Question 3 (10 marks)

- [x] ~~Users can add and delete data from the **Restaurant** table.~~
- [x] ~~Users can add and delete data from the **Rater** table.~~
- [x] ~~Users can add and delete data from the **MenuItem** table.~~

### Question 4 (40 marks)

#### Restaurants and Menus

- [x] ~~a1) The system must display a lists of restaurants.~~
- [x] ~~a2) The system must display the information found in the restaurant and location tables when a user selects a restaurant.~~
- [x] ~~b1) The system must display the full menu for a specific restaurant.~~
- [x] ~~b2) The system must display all menu items and their prices for a specific restaurant.~~
- [x] ~~b3) The system must filter displayed menu items based on their categories.~~
- [x] ~~c1) The system must list the names of managers as well as the date the restaurant opened when provided with the category of a restaurant.~~
- [x] ~~d1) The system must display the name of the most expensive menu item when provided with a restaurant.~~
- [x] ~~d2) The system must display the opening hours, and the URL for the restaurant.~~
- [X] ~~e1) The system must list the average prices of the menu items, for each category of menu item, for each category of restaurant.~~

#### Ratings of restaurants

- [x] ~~f1) Find the total number of rating for each restaurant, for each rater. That is, the data should be grouped by the restaurant, the specific raters and the numeric ratings they have received.~~
- [x] ~~f1) For each rater, the system must display the total number of ratings for each restaurant.~~

- [x] ~~g1) The system must display a list of restaurants which have not been reated for a given month.~~ (currently only works for January, which is what was specified in the assignment description)
- [x] ~~g2) The system must display the name of the restaurant, the phone number, and the type of food.~~

- [x] ~~h1) The system must display the names and opening dates for a given restaurant which obtained Staff rating which is lower than any rating given by a rater.~~
- [x] ~~h2) The system must order the results by the dates of the ratings.~~

- [x] ~~i) List the details of the Type Y restaurants that obtained the highest Food rating. Display the restaurant name together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.)~~
- [x] ~~i) The system must list the details of the highest rated (by food) restaurants for each respective category of restaurant.~~
- [x] ~~j) Provide a query to determine whether Type Y restaurants are “more popular” than other restaurants. (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.) Yes, this query is open to your own interpretation!~~

#### Raters and their ratings

- [x] ~~k) Find the names, join‐date and reputations of the raters that give the highest overall rating, in terms of the **Food _and_ the Mood** of restaurants. _Display this information together with the names of the restaurant and the dates the ratings were done._~~
- [x] ~~l) Find the **names** and **reputations** of the raters that give the **highest overall rating**, in terms of the **Food _or_ the Mood** of restaurants. _Display this information together with the names of the restaurant and the dates the ratings were done._~~
- [x] ~~m) Find the names and reputations of the raters that rated a specific restaurant (say Restaurant Z) the most frequently. Display this information together with their comments and the names and prices of the menu items they discuss. (Here Restaurant Z refers to a restaurant of your own choice, e.g. Ma Cuisine).~~
- [x] ~~n) Find the names and emails of all raters who gave ratings that are lower than that of a rater with a name called John, in terms of the combined rating of Price, Food, Mood and Staff. (Note that there may be more than one rater with this name).~~
- [x] ~~o) Find the names, types and emails of the raters that provide the most diverse ratings. Display this information together with the restaurants names and the ratings. For example, Jane Doe may have rated the Food at the Imperial Palace restaurant as a 1 on 1 January 2015, as a 5 on 15 January 2015, and a 3 on 4 February 2015. Clearly, she changes her mind quite often.~~

### Front-end (30 marks)

- [x] ~~Create a web‐based front‐end, for the user to directly query the database.~~

### Bonus (20 marks)

- [x] ~~Additional effort, such as creating a superb front‐end, conducting sentiment analysis (i.e., text mining), or including a multimedia component, may earn you up to 20 bonus marks.~~
