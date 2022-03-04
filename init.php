<?php

use Carbon\Carbon;

// ini_set('display_errors',1);
// error_reporting(E_ALL);

// Start session
session_start();

// composer packages autoload
require __DIR__ . '/vendor/autoload.php'; 

// Autoload for models
require __DIR__ . '/core/models/autoload.php'; 

// Load utils
// Utility functions
require __DIR__ . '/core/utils/functions.php';

// Load routes
require __DIR__ . '/core/config/routing.php';
require __DIR__ . '/core/config/admin_routing.php';

// Database connection
require __DIR__ . '/core/utils/db.php';

// Other config
require __DIR__ . '/core/config/misc.php';

// Session management
require __DIR__ . '/core/utils/SessionManager.php';

// Visit Tracker
require __DIR__ . '/core/utils/VisitTracker.php';

// Track visits on main site
if(!isAdminContext()){
    VisitTracker::track();
}
