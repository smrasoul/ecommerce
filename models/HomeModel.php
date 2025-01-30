<?php

// Declare the variable that will hold the fetched product data
$products = [];

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

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$productsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Process the products to group categories for each product
foreach ($productsArray as $row) {
    $prod_id = $row['id'];

    if (!isset($products[$prod_id])) {
        $products[$prod_id] = $row;
        $products[$prod_id]['categories'] = [];
    }

    $products[$prod_id]['categories'][] = $row['category'];
}