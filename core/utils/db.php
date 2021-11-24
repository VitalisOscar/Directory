<?php

// Import db configurations
require __DIR__ . '/../config/db.php';

function db(){
    return mysqli_connect(
        CONN_HOST,
        CONN_USER,
        CONN_PASSWORD,
        DB_NAME
    );
}
