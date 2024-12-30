<?php

require 'includes/init.php';
require 'src/Product/Function/product-Function.php';

$userPermissions = checkUserAccess($conn, 'delete_product');

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];
    $product = getById($conn, $product_id);

    if ($product) {
        deleteProduct($product_id, $conn);
    } else {
        die("Product not found");
    }

} else {
    die("ID not supplied. Product not found.");
}
