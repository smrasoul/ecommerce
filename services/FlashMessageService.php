<?php

function setFlashMessage(array $results): bool
{
    $messages = [
        'photo' => "Uploading photo failed.",
        'product' => "Failed to add the product.",
        'product_update' => "Failed to update the product.",
        'media' => "Failed to attach product image.",
        'categories' => "Failed to assign categories.",
        'photo_delete' => "Failed to remove product image.",
        'product_delete' => "Failed to delete product image.",
        'media_delete' => "Failed to delete product image.",
        'categories_delete' => "Failed to delete category image.",
        'user' => "Failed to edit information.",
        'password' => "Failed to update password.",
    ];

    foreach ($results as $key => $value) {
        if ($value === false) {
            $_SESSION['flash_danger'] = $messages[$key] ?? "An unknown error occurred.";
            return false; // Return immediately on first failure
        }
    }

    // Check if the product was successfully added
    if (!empty($results['product']) && $results['product'] === true) {
        $_SESSION['flash_success'] = "Product added successfully.";
    } elseif (!empty($results['user']) && $results['user'] === true) {
        $_SESSION['flash_success'] = "Information updated successfully.";
    } elseif (!empty($results['password']) && $results['password'] === true) {
        $_SESSION['flash_success'] = "Password updated successfully.";
    } elseif (!empty($results['product_update']) && $results['product_update'] === true) {
        $_SESSION['flash_success'] = "Product updated successfully.";
    }

    return true; // Return true if everything succeeded
}
