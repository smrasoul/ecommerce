<?php

require 'includes/init.php';

$userPermissions = checkUserAccess($conn, 'delete_product');

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];
    $product = getById($conn, $product_id);

    if ($product) {

        $id = $product['id'];

    } else {
        die("Product not found");
    }

} else {
    die("id not supplied, Product not found");
}

deleteProduct($product, $conn);



