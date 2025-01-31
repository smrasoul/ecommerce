<?php

require 'config/config.php';

global $conn; // Declare the global variable

function getDbConnection()
{
    global $conn; // Access the global variable within the function

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    mysqli_set_charset($conn, "utf8");

    return $conn;
}

// Call the function to initialize the connection
getDbConnection();


