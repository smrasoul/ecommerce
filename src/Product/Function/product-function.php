<?php

function fetchAllProducts($conn) {
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function addProduct($name, $price, $photo_name, $conn) {
    $query = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sd', $name, $price);

    if (mysqli_stmt_execute($stmt)) {
        $product_id = mysqli_insert_id($conn);
        addMedia($product_id, $photo_name, $conn);
        $_SESSION['flash']['product_success'] = 'Product added successfully.';
        redirect('/View-product.php');
        exit;
    } else {
        $_SESSION['product_failure'] = "Failed to save product.";
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

function deleteProduct($product_id, $conn) {
    // Delete associated media
    deleteMedia($product_id, $conn);

    // Delete the product record from the database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash']['delete_success'] = "Product deleted successfully.";
        redirect('/View-product.php');
    } else {
        $_SESSION['flash']['delete_failure'] = "Failed to delete the product.";
        redirect('/View-product.php');
    }
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

function addMedia($product_id, $media_name, $conn) {
    $query = "INSERT INTO media (product_id, media_type, file_path) VALUES (?, 'image', ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $product_id, $media_name);
    mysqli_stmt_execute($stmt);
}

function deleteMedia($product_id, $conn) {
    // Fetch media associated with the product
    $media = fetchMediaByProductId($product_id, $conn);

    // Delete media files
    foreach ($media as $item) {
        if (file_exists('assets/media/' . $item['file_path'])) {
            unlink('assets/media/' . $item['file_path']);
        }
    }

    // Delete media records from the database
    $query = "DELETE FROM media WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
}

function fetchMediaByProductId($product_id, $conn) {
    $query = "SELECT * FROM media WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function updateProduct($conn, $name, $price, $photo_name, $product_id) {
    $query = "UPDATE products SET name = ?, price = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sdi', $name, $price, $product_id);
    if (mysqli_stmt_execute($stmt)) {
        if ($photo_name) {
            handleMedia($product_id, ['name' => $photo_name], $conn); // Pass the updated media name
        }
        $_SESSION['flash']['product_success'] = 'Product updated successfully.';
        redirect('/View-product.php');
        exit;
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
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


function getProductsWithMedia($conn, $products)
{
    $productsWithMedia = [];
    foreach ($products as $product) {
        $media = fetchMediaByProductId($product['id'], $conn);
        $product['media'] = !empty($media) ? $media[0]['file_path'] : null;
        $productsWithMedia[] = $product;
    }
    return $productsWithMedia;
}



