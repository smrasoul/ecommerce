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
    } else {
        $_SESSION['flash']['product_failure'] = "Failed to add the product.";
    }
    return $success;
}

function fetchProductImageById($product_id)
{
    global $conn;
    $query = "SELECT * FROM media WHERE mediable_id = ? AND mediable_type = 'products' AND media_type = 'image'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Return the first image associated with the product
    return mysqli_fetch_assoc($result);
}

function deleteProductImage($product_id) {

    global $conn;
    // Fetch media associated with the product (image specifically)
    $item = fetchProductImageById($product_id);

    // Check if the product has an image
    if ($item) {
        // Delete the media file
        if (file_exists('assets/media/' . $item['file_path'])) {
            unlink('assets/media/' . $item['file_path']);
        }

        // Delete the media record from the database for the product image
        $query = "DELETE FROM media WHERE mediable_id = ? AND mediable_type = 'products' AND media_type = 'image'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
        mysqli_stmt_execute($stmt);

        // Check if the delete operation was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            return true;  // Success
        }
    }

    return false;  // Failure
}



function editProductImage($product_id, $photo)
{

    if (!empty($photo['name'])) { // If new photo is uploaded
        $new_photo_name = time() . '_' . basename($photo['name']);
        $upload_path = 'assets/media/' . $new_photo_name;

        move_uploaded_file($photo['tmp_name'], $upload_path);
        // Add or update media record
        deleteProductImage($product_id); // Delete previous media if it exists
        addProductImage($product_id, $new_photo_name);
    }
}

function deleteProductCategories($product_id)
{

    global $conn;
    $query = "DELETE FROM product_categories WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    return (mysqli_stmt_execute($stmt));
}


function processProductCategories($product_id, $categoryIds){
    if(deleteProductCategories($product_id)){
        if(addProductCategories($product_id, $categoryIds)){
            $_SESSION['flash']['product_success'] = "product updated successfully.";
            redirect('/product-management');
        } else {
            $_SESSION['product_failure'] = "Failed to update the product.";
            return false;
        }
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
        return false;
    }
}

function updateProduct($name, $price, $photo, $product_id, $categoryIds)
{

    global $conn;

    $query = "UPDATE products SET name = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sdi', $name, $price, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        editProductImage($product_id, $photo);
        processProductCategories($product_id, $categoryIds);
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
        exit;
    }
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



