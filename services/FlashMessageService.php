<?php

function setFlashMessage(array $results): bool
{
    $failureMessages = [
        'photo' => "Uploading photo failed.",
        'product' => "Failed to add the product.",
        'product_update' => "Failed to update the product.",
        'media' => "Failed to attach product image.",
        'categories' => "Failed to assign categories.",
        'photo_delete' => "Failed to remove product image.",
        'product_delete' => "Failed to delete product.",
        'media_delete' => "Failed to delete product image.",
        'categories_delete' => "Failed to delete category image.",
        'user' => "Failed to edit information.",
        'password' => "Failed to update password.",
        'login' => "Wrong username or password.",
        'signup' => "Failed to sign up.",
        'new_role' => "Failed to add new role.",
        'role_delete' => "Failed to delete role.",
        'role_assign' => "Failed to assign role.",
        'user_role' => "Failed to change user role.",
    ];

    $successMessages = [
        'product' => "Product added successfully.",
        'user' => "Information updated successfully.",
        'password' => "Password updated successfully.",
        'product_update' => "Product updated successfully.",
        'product_delete' => "Product deleted successfully.",
        'signup' => "Registration successful.",
        'new_role' => "New role added successfully.",
        'role_assign' => "New role added successfully.",
        'user_role' => "Role changed successfully.",

    ];

    foreach ($results as $key => $value) {
        if ($value === false) {
            $_SESSION['flash_danger'] = $failureMessages[$key] ?? "An unknown error occurred.";
            return false; // Stop at first failure
        }
    }

    // Set the first matching success message
    foreach ($successMessages as $key => $message) {
        if (!empty($results[$key]) && $results[$key] === true) {
            $_SESSION['flash_success'] = $message;
            break; // Stop at the first success match
        }
    }

    return true; // Return true if everything succeeded
}
