<?php

require 'includes/init.php';

if (!has_permission('delete_product')) {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = get_db_connection();

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];
    $product = get_by_id($conn, $product_id);

    if ($product) {

        $id = $product['id'];

    } else {
        die("Product not found");
    }

} else {
    die("id not supplied, Product not found");
}

$errors = delete_product($product, $conn);

if (empty($errors)) {
    redirect('/admin/dashboard.php'); // Redirect to admin dashboard after successful deletion
} else {
    foreach ($errors as $error) {
        echo "<p>$error</p>"; // Display errors
    }
}

mysqli_close($conn);



