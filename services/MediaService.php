<?php

function uploadProductPhoto($photo){
    $photo_name = time() . '_' . basename($photo['name']);
    $upload_path = 'assets/media/' . $photo_name;
    if(move_uploaded_file($photo['tmp_name'], $upload_path)){
        return $photo_name;
    }else {
        $_SESSION['product_errors']['photo'] = "Failed to upload photo.";
    }
}
