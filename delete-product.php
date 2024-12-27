<?php

require 'includes/init.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);

    if (!hasPermission('delete_product', $userPermissions)) {
        header('HTTP/1.1 403 Forbidden');
        echo "You do not have permission to access this page.";
        exit;
    }

} else {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

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



