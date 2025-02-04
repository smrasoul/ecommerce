<?php

// Declare the variable that will hold the fetched product data

function fetchAllProducts()
{

    global $conn;

    $query = "SELECT 
            products.id, 
            products.name, 
            products.price, 
            media.file_path AS main_image
          FROM products
          LEFT JOIN media ON products.id = media.product_id AND media.media_type = 'main_image'";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
}