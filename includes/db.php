<?php

require 'config.php' ;


function get_db_connection()
{

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    mysqli_set_charset($conn, "utf8");

    return $conn;
}

