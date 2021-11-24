<?php

const BASE_URL = 'http://localhost/projects/places/';

const ROUTE_HOME = BASE_URL;

// Auth
const ROUTE_SIGNIN = BASE_URL . 'auth/signin.php';
const ROUTE_SIGNOUT = BASE_URL . 'auth/signout.php';
const ROUTE_REGISTER = BASE_URL . 'auth/signup.php';

// User
const ROUTE_USER_DASHBOARD = BASE_URL . 'user/dashboard.php';
const ROUTE_USER_REVIEWS = 'user/reviews.php';

// Business
const ROUTE_USER_BUSINESSES = BASE_URL . 'user/places/all.php';
const ROUTE_ADD_BUSINESS = BASE_URL . 'user/places/add.php';
const ROUTE_SINGLE_USER_BUSINESS = BASE_URL . 'user/places/single.php';
const ROUTE_SINGLE_USER_BUSINESS_REVIEWS = ROUTE_SINGLE_USER_BUSINESS . '?section=reviews';

// Business Discovery
const ROUTE_FIND_BUSINESSES = BASE_URL . 'places/discover.php';
const ROUTE_BUSINESS_DETAIL = BASE_URL . 'places/details.php';
const ROUTE_ADD_REVIEW = BASE_URL . 'places/add_review.php';
