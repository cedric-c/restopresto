<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */

require_once('classes/Model.php');
require_once('classes/Renderable.php');
require_once('classes/View.php');
require_once('classes/Controller.php');
require_once('classes/Connection.php');
require_once('classes/App.php');
require_once('classes/Location.php');
require_once('classes/Webpage.php');
require_once('classes/Rating.php');
require_once('classes/Response.php');
require_once('classes/MenuItem.php');
require_once('classes/ControllerSession.php');

// Restaurant App
require_once('restaurant/Restaurant.php');
require_once('restaurant/ViewRestaurant.php');
require_once('restaurant/ControllerRestaurant.php');
require_once('restaurant/ViewRestaurantRoaster.php');
require_once('restaurant/ControllerRestaurantRoaster.php');

// Dashboard App
require_once('dashboard/ControllerDashboard.php');
require_once('dashboard/ViewDashboard.php');
require_once('dashboard/Dashboard.php');

// Person App
require_once('person/Person.php');
require_once('person/ViewPerson.php');
require_once('person/ControllerPerson.php');
require_once('person/ViewPersonRoaster.php');
require_once('person/ControllerPersonRoaster.php');
