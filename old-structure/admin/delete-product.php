<?php

require 'includes/init.php';

if (!hasPermission('delete_product')) {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = getDbConnection();

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

$errors = deleteProduct($product, $conn);

if (empty($errors)) {
    redirect('/admin/dashboard.php'); // Redirect to admin dashboard after successful deletion
} else {
    foreach ($errors as $error) {
        echo "<p>$error</p>"; // Display errors
    }
}

mysqli_close($conn);



