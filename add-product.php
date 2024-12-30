<?php

require 'includes/init.php';
require 'src/Product/Validation/product-validation.php';
require 'src/Product/Function/product-function.php';

$userPermissions = checkUserAccess($conn, 'add_product');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];


    validateProduct($name, $price, $photo);
    $formFeedback = productFeedback();


    if (empty($formFeedback)) {
        $photo_name = time() . '_' . basename($photo['name']);
        $upload_path = 'assets/media/' . $photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path)) {
            addProduct($name, $price, $photo_name, $conn);
        } else {
            $_SESSION['product_errors']['photo'] = "Failed to upload photo.";
        }
    }
}

?>

<?php require 'includes/View/header.php' ?>

<h1 class="my-4">Add Product</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
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

<?php require 'includes/View/footer.php' ?>
