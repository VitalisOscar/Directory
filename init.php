<?php

// Start session
session_start();

// Autoload for models
require __DIR__ . '/core/models/autoload.php'; 

// Load utils
// Utility functions
require __DIR__ . '/core/utils/functions.php';

// Load routes
require __DIR__ . '/core/config/routing.php';

// Database connection
require __DIR__ . '/core/utils/db.php';

// Other config
require __DIR__ . '/core/config/misc.php';

// Session management
require __DIR__ . '/core/utils/session.php';

// Initialize session
