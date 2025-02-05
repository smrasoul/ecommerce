<?php

// Declare the variable that will hold the fetched product data

function fetchAllProducts()
{
    global $conn;

    // Query to fetch products along with their associated media (main image)
    $query = "SELECT 
                p.id, 
                p.name, 
                p.price, 
                m.file_path AS main_image
              FROM products p
              LEFT JOIN media m ON p.id = m.mediable_id AND m.mediable_type = 'products' AND m.media_type = 'image'";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all products as associative array
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
