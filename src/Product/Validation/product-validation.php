<?php

function validateProduct($name, $price, $photo, $is_update = false) {
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
