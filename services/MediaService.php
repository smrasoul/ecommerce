<?php

function uploadPhotoToStorage($photo) {
    $photo_name = time() . '_' . basename($photo['name']);
    $upload_path = 'assets/media/' . $photo_name;

    if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
        // Detect MIME type of the uploaded file
        $mime_type = mime_content_type($upload_path); // e.g., "image/jpeg"
        return ['file_name' => $photo_name, 'mime_type' => $mime_type];
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

function createProductImage($product_id, $photoData) {
    if (!$photoData) {
        return false;
    }
    return createMedia($product_id, 'products', $photoData['file_name'], $photoData['mime_type']);
}

function fetchProductImageById($product_id) {
    global $conn;
    $query = "SELECT * FROM media WHERE mediable_id = ? AND mediable_type = 'products' AND media_type LIKE 'image/%'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function deletePhotoFromStorage($product_id) {
    $item = fetchProductImageById($product_id);

    if ($item && file_exists('assets/media/' . $item['file_path'])) {
        return unlink('assets/media/' . $item['file_path']);
    }

    return false;
}

function deleteMedia($product_id) {
    global $conn;
    $query = "DELETE FROM media WHERE mediable_id = ? AND mediable_type = 'products' AND media_type LIKE 'image/%'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt) > 0;
}
