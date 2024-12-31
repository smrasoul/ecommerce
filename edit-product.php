<?php

require 'includes/init.php';
require 'src/Product/Function/product-Function.php';
require 'src/Product/Validation/product-Validation.php';

$userPermissions = checkUserAccess($conn, 'edit_product');

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];

$product = fetchAllProductDetails($conn, $product_id);
//var_dump($product);
//echo "<br>";

if (!$product) {
    die("Product not found.");
}

$categories = getAllCategories($conn);
//var_dump($categories);

$activePage = 'view-product';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $categoryIds = $_POST['category'] ?? [];

    // Validate input fields
    validateProduct($name, $price, $photo, $is_update = true);

    // Handle photo upload and update
    $photo_name = handleMedia($product_id, $photo, $conn);

    $formFeedback = productFeedback();

    // Update the product in the database
    if (empty($formFeedback)) {
        updateProduct($conn, $name, $price, $photo_name, $product_id);
        processProductCategories($product_id, $categoryIds, $conn);
    }
}



?>

<?php require 'includes/View/header.php'; ?>

<h1 class="my-4">Edit Product</h1>

<div class="row">

    <div class="col-3">
       <?php require 'includes/View/sidebar.php'; ?>
    </div>

    <div class="col-9 border rounded py-3">

        <?php if (isset($_SESSION['product_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['product_failure'] ?>
            </div>
            <?php unset($_SESSION['product_failure']) ?>
        <?php endif; ?>


        <?php require 'src/Product/View/product-form.php'; ?>

    </div>

</div>

<?php require 'includes/View/footer.php'; ?>
