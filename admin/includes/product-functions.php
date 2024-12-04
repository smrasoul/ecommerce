<?php

function validateProduct($name, $price, $photo, $is_update = false)
{
    $errors = array();

    // Validate product name
    if (empty($name)) {
        $errors[] = "Product name is required.";
    }

    // Validate price
    if (empty($price) || !is_numeric($price) || $price <= 0) {
        $errors[] = "Invalid price.";
    }

    // Validate photo only if it's not an update or if a new photo is uploaded
    if (!$is_update || !empty($photo['name'])) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!empty($photo['name']) && !in_array($photo['type'], $allowed_types)) {
            $errors[] = "Only JPG and PNG files are allowed.";
        }
        if (!empty($photo['size']) && $photo['size'] > 2 * 1024 * 1024) {
            $errors[] = "File size must be less than 2MB.";
        }
        if (empty($photo['name'])) {
            $errors[] = "Product photo is required.";
        }
    }

    return $errors;
}


function addProduct($name, $price, $photo_name, $conn)
{

    $query = "INSERT INTO products (name, price, photo) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sds', $name, $price, $photo_name);

    if (mysqli_stmt_execute($stmt)) {
        redirect('/admin/dashboard.php');
        exit;
    } else {
        $errors[] = "Failed to save product.";
    }
    return $errors;
}

function getById($conn, $product_id) {

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $product = mysqli_fetch_assoc($result);
}

function deleteProduct($product, $conn) {

    $errors = [];

    // Delete the photo file if it exists
    if (!empty($product['photo']) && file_exists($product['photo'])) {
        if (!unlink($product['photo'])) {
            $errors[] = "Failed to delete the product photo.";
            return $errors;
        }
    }

    // Delete the product record from the database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product['id']);

    if (!mysqli_stmt_execute($stmt)) {
        $errors[] = "Failed to delete the product.";
    }

    return $errors;
}

function handlePhoto ($product, $photo)
{
    // Handle photo upload
    $photo_name = $product['photo']; // Default to the existing photo

    if (!empty($photo['name'])) { // If a new photo is uploaded
        $new_photo_name = time() . '_' . basename($photo['name']);
        $upload_path = '../assets/images/' . $new_photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
            // Delete the old photo if it exists
            if (!empty($product['photo']) && file_exists('../assets/images/' . $product['photo'])) {
                unlink('../assets/images/' . $product['photo']);
            }
            $photo_name = $new_photo_name;
        }
    }
    return $photo_name;
}

function updateProduct ($conn, $name, $price, $photo_name, $product_id ){

    $query = "UPDATE products SET name = ?, price = ?, photo = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sdsi', $name, $price, $photo_name, $product_id);
    return mysqli_stmt_execute($stmt);

}


