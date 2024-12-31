<?php

require 'includes/init.php';
require 'src/Product/Function/product-Function.php';

$userPermissions = checkUserAccess($conn, 'delete_product');

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];
    $product = getById($conn, $product_id);

    if ($product) {
        if (!deleteProductCategories($product_id, $conn)) {
            $_SESSION['flash']['product_failure'] = 'Failed to delete the product.';
        } elseif (!deleteProduct($product_id, $conn)) {
            $_SESSION['flash']['product_failure'] = 'Failed to delete the product.';
        } else {
            $_SESSION['flash']['product_success'] = 'The product was successfully deleted.';
            redirect('/view-product.php');
        }
    }

} else {
    die("ID not supplied. Product not found.");
}
