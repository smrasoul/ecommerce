<?php

function uploadPhotoToStorage($photo){

    $photo_name = time() . '_' . basename($photo['name']);
    $upload_path = 'assets/media/' . $photo_name;
    if(move_uploaded_file($photo['tmp_name'], $upload_path)) {
        return $photo_name;
    }
    return false;
}

function createMedia($mediable_id, $mediable_type, $media_name, $media_type) {

    global $conn;
    $query = "INSERT INTO media (mediable_id, mediable_type, media_type, file_path) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $mediable_id, $mediable_type, $media_type, $media_name);
    return mysqli_stmt_execute($stmt);

}

function createProductImage($product_id, $photo_name) {
    return createMedia($product_id, 'products', $photo_name, 'image');
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

function deletePhotoFromStorage($product_id)
{

    // Fetch media associated with the product (image specifically)
    $item = fetchProductImageById($product_id);
    // Delete the media file
    if (file_exists('assets/media/' . $item['file_path'])) {
        return unlink('assets/media/' . $item['file_path']);
    }
    return false;
}

function deleteMedia($product_id){

    global $conn;
    $query = "DELETE FROM media WHERE mediable_id = ? AND mediable_type = 'products' AND media_type = 'image'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);

    // Check if the delete operation was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;  // Success
    }

    return false;
}
