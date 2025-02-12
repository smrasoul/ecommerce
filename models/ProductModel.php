<?php

function ShowProduct($product_id = null)
{
    global $conn;

    // Query to fetch product details with categories and media (image)
    $query = "SELECT 
                p.id, 
                p.name, 
                p.price, 
                c.name AS category,
                m.file_path AS main_image
              FROM products p
              JOIN product_categories pc ON p.id = pc.product_id
              JOIN categories c ON pc.category_id = c.id
              LEFT JOIN media m ON p.id = m.mediable_id AND m.mediable_type = 'products' AND m.media_type = 'image'";

    if ($product_id !== null) {
        $query .= " WHERE p.id = ?";
    }

    $stmt = mysqli_prepare($conn, $query);

    if ($product_id !== null) {
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $productsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Organize products and their categories
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

    // Return the product details (specific or all products)
    if ($product_id !== null && isset($products[$product_id])) {
        return $products[$product_id];
    }

    return $products;
}



function getAllCategories() {
    global $conn;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}




function createProduct($name, $price) {
    global $conn;

    // Insert the product into the products table
    $query = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sd', $name, $price);

    if (mysqli_stmt_execute($stmt)) {
        // Get the last inserted product ID
        return mysqli_insert_id($conn);
    } else {
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

    return $success;
}



function deleteProductCategories($product_id)
{

    global $conn;
    $query = "DELETE FROM product_categories WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    return (mysqli_stmt_execute($stmt));
}

function updateProduct($name, $price, $product_id)
{

    global $conn;

    $query = "UPDATE products SET name = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sdi', $name, $price, $product_id);
    return mysqli_stmt_execute($stmt);

}

function getProductById($product_id) {

    global $conn;
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function deleteProductById($product_id)
{

    global $conn;
    // Step 2: Delete the product record from the database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);

    return (mysqli_stmt_execute($stmt));

}



