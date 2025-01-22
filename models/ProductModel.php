<?php

function fetchAllProductDetails($conn, $product_id) {
    $query = "SELECT 
                products.id, 
                products.name, 
                products.price, 
                categories.name AS category,
                media.file_path AS main_image
              FROM products
              JOIN product_categories ON products.id = product_categories.product_id
              JOIN categories ON product_categories.category_id = categories.id
              LEFT JOIN media ON products.id = media.product_id AND media.media_type = 'main_image'";

    if ($product_id !== null) {
        $query .= " WHERE products.id = ?";
    }

    $stmt = mysqli_prepare($conn, $query);

    if ($product_id !== null) {
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $productsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $products = [];
    foreach ($productsArray as $row) {
        $prod_id = $row['id'];

        // If product is not already in the array, add it
        if (!isset($products[$prod_id])) {
            $products[$prod_id] = $row;
            $products[$prod_id]['categories'] = [];
        }

        // Add the category to the product's categories array
        $products[$prod_id]['categories'][] = $row['category'];
    }

    // If a specific product ID was requested, return only that product's details
    if ($product_id !== null && isset($products[$product_id])) {
        return $products[$product_id];
    }

    // Otherwise, return the array of all products
    return $products;
}
