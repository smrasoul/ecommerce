<?php

function fetchAllProductDetails($product_id = null) {

    global $conn;

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

function getAllCategories() {
    global $conn;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addMedia($product_id, $media_name)
{
    global $conn;
    $query = "INSERT INTO media (product_id, media_type, file_path) VALUES (?, 'main_image', ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $product_id, $media_name);
    mysqli_stmt_execute($stmt);
}

function addProduct($name, $price, $photo_name) {

    global $conn;

    $query = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sd', $name, $price);

    if (mysqli_stmt_execute($stmt)) {
        $product_id = mysqli_insert_id($conn);
        addMedia($product_id, $photo_name, $conn);
        return $product_id;  // Make sure to return the product ID here
    } else {
        $_SESSION['product_failure'] = "Failed to save product.";
        return false;
    }
}

function addProductCategories($product_id, $categoryIds){

    global $conn;

    $query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";

    $success = true;
    foreach ($categoryIds as $categoryId) {
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt === false) {
            $success = false;
            break;
        }

        mysqli_stmt_bind_param($stmt, 'ii', $product_id, $categoryId);
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $_SESSION['flash']['product_success'] = 'Product added successfully.';
        redirect('/product-management');
    } else {
        $_SESSION['flash']['product_failure'] = "Failed to add the product.";
    }
}

