<?php

function fetchAllProductDetails($product_id = null)
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

function addMedia($mediable_id, $mediable_type, $media_name, $media_type) {
    global $conn;

    $query = "INSERT INTO media (mediable_id, mediable_type, media_type, file_path) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $mediable_id, $mediable_type, $media_type, $media_name);

    mysqli_stmt_execute($stmt);
}

function addProductImage($product_id, $photo_name) {
    addMedia($product_id, 'products', $photo_name, 'image');
}


function addProduct($name, $price, $photo_name) {
    global $conn;

    // Insert the product into the products table
    $query = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sd', $name, $price);

    if (mysqli_stmt_execute($stmt)) {
        // Get the last inserted product ID
        $product_id = mysqli_insert_id($conn);

        // Add the product image using the specific function
        addProductImage($product_id, $photo_name);

        // Return the product ID after successful insertion
        return $product_id;
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

