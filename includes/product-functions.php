<?php


function fetchAllProducts($conn){
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    return $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function validateProduct($name, $price, $photo, $is_update = false)
{

    if ($name == '') {
        $_SESSION['product_errors']['name'] = "Product name is required.";
    }


    if (($price == '') || !is_numeric($price) || $price <= 0) {
        $_SESSION['product_errors']['price'] = "Invalid price.";
    }

    // Validate photo only if it's not an update or if a new photo is uploaded
    if (!$is_update || !empty($photo['name'])) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!empty($photo['name']) && !in_array($photo['type'], $allowed_types)) {
            $_SESSION['product_errors']['photo'] = "Only JPG and PNG files are allowed.";
        }
        if (!empty($photo['size']) && $photo['size'] > 2 * 1024 * 1024) {
            $_SESSION['product_errors']['photo'] = "File size must be less than 2MB.";
        }
        if (empty($photo['name'])) {
            $_SESSION['product_errors']['photo'] = "Product photo is required.";
        }
    }
}


function addProduct($name, $price, $photo_name, $conn)
{

    $query = "INSERT INTO products (name, price, photo) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sds', $name, $price, $photo_name);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash']['product_success'] = 'Product added successfully.';
        redirect('/view-product.php');
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
    return $product = mysqli_fetch_assoc($result);
}

function deleteProduct($product, $conn) {

    // Delete the photo file if it exists
    if (!empty($product['photo']) && file_exists($product['photo'])) {
        if (!unlink($product['photo'])) {
            $_SESSION['product_errors']['delete'] = "Failed to delete the product photo.";
        }
    }

    // Delete the product record from the database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product['id']);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['product_errors']['delete'] = "Failed to delete the product.";
    }
}

function handlePhoto ($product, $photo)
{
    // Handle photo upload
    $photo_name = $product['photo']; // Default to the existing photo

    if (!empty($photo['name'])) { // If a new photo is uploaded
        $new_photo_name = time() . '_' . basename($photo['name']);
        $upload_path = 'assets/images/' . $new_photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
            // Delete the old photo if it exists
            if (!empty($product['photo']) && file_exists('assets/images/' . $product['photo'])) {
                unlink('assets/images/' . $product['photo']);
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
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash']['product_success'] = 'Product updated successfully.';
        redirect('/view-product.php');
        exit;
    } else {
        $_SESSION['product_failure'] = "Failed to update the product.";
    }

}

function productFeedback(){
    $formFeedback = '';
    if(isset($_SESSION['product_errors'])) {
        $formFeedback = $_SESSION['product_errors'];
        unset($_SESSION['product_errors']);
    }
    return $formFeedback;
}


