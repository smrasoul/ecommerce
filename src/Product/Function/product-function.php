<?php

function fetchAllProductDetails($conn, $product_id = null) {
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


function addProduct($name, $price, $photo_name, $conn) {
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

function getById($conn, $product_id) {
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}





function addMedia($product_id, $media_name, $conn)
{
    $query = "INSERT INTO media (product_id, media_type, file_path) VALUES (?, 'main_image', ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $product_id, $media_name);
    mysqli_stmt_execute($stmt);
}

function fetchMediaByProductId($conn, $product_id)
{
    $query = "SELECT * from media WHERE media_type = 'main_image' AND product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function deleteMedia($product_id, $conn) {
    // Fetch media associated with the product
    $item = fetchMediaByProductId($conn, $product_id);

    // Delete media files

        if (file_exists('assets/media/' . $item['file_path'])) {
            unlink('assets/media/' . $item['file_path']);
        }


    // Delete media records from the database
    $query = "DELETE FROM media WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
}

function handleMedia($product_id, $photo, $conn) {
    // Handle photo upload
    if (!empty($photo['name'])) { // If new photo is uploaded
        $new_photo_name = time() . '_' . basename($photo['name']);
        $upload_path = 'assets/media/' . $new_photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
            // Add or update media record
            deleteMedia($product_id, $conn); // Delete previous media if it exists
            addMedia($product_id, $new_photo_name, $conn);
            return $new_photo_name;
        }
    }
    return null;
}

function updateProduct($conn, $name, $price, $photo_name, $product_id)
{
    $query = "UPDATE products SET name = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sdi', $name, $price, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        if ($photo_name) {
            handleMedia($product_id, ['name' => $photo_name], $conn); // Pass the updated media name
        }
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
        exit;
    }
}

function productFeedback() {
    $formFeedback = '';
    if (isset($_SESSION['product_errors'])) {
        $formFeedback = $_SESSION['product_errors'];
        unset($_SESSION['product_errors']);
    }
    return $formFeedback;
}

function getAllCategories($conn) {
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deleteProductCategories($product_id, $conn)
{
    $query = "DELETE FROM product_categories WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    return (mysqli_stmt_execute($stmt));
}

function addProductCategories($product_id, $categoryIds, $conn){
    $query = "INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)";

    foreach ($categoryIds as $categoryId) {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $product_id, $categoryId);
        mysqli_stmt_execute($stmt);
    }
    return true;
}

function processProductCategories($product_id, $categoryIds, $conn){
    if(deleteProductCategories($product_id, $conn)){
        if(addProductCategories($product_id, $categoryIds, $conn)){
            $_SESSION['flash']['product_success'] = "product updated successfully.";
            redirect('/view-product.php');
        } else {
            $_SESSION['product_failure'] = "Failed to update the product.";
            return false;
        }
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
        return false;
    }
}

function deleteProduct($product_id, $conn)
{
    // Step 1: Delete associated media
    deleteMedia($product_id, $conn);

    // Step 2: Delete the product record from the database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);

    return (mysqli_stmt_execute($stmt));

}
