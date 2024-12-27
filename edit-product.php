<?php

require 'includes/init.php';

$userPermissions = checkUserAccess($conn, 'edit_product');

$conn = getDbConnection();


if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];


$product = getById($conn, $product_id);
if (!$product) {
    die("Product not found.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];

    // Validate input fields
    validateProduct($name, $price, $photo, $is_update = true);

    if(! $photo_name = handlePhoto($product, $photo)) {
        $_SESSION['product_errors']['photo'] = "Failed to upload the new photo.";
    }

    $formFeedback = productFeedback();
    var_dump($formFeedback);

    // Update the product in the database
    if (empty($formFeedback)) {

        if (!updateProduct($conn, $name, $price, $photo_name, $product_id)) {
            $_SESSION['product_failure'] = "Failed to update the product.";
        }
    }


    if(empty($formFeedback)) {
        redirect('/view-product.php');
    }
}

mysqli_close($conn);

?>

<?php require 'includes/header.php'; ?>

<h1 class="my-4">Edit Product</h1>

<div class="row">

    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                   href="account-info.php">Account information</a>
            </li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                   href="orders.php">Orders history</a>
            </li>
            <?php if (hasPermission('view_product', $userPermissions)): ?>
                <li class="list-group-item bg-secondary-subtle">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                       href="view-product.php">Product Management</a></li>
            <?php endif; ?>
            <?php if (hasPermission('manage_user', $userPermissions)): ?>
                <li class="list-group-item">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                       href="manage-user.php">User Management</a></li>
            <?php endif ?>
        </ul>
    </div>

    <div class="col-9 border rounded py-3">

        <?php if (isset($_SESSION['product_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['product_failure'] ?>
            </div>
            <?php unset($_SESSION['product_failure']) ?>
        <?php endif; ?>

        <!-- Shared product form -->
        <form method="POST" enctype="multipart/form-data">
            <?php require 'includes/product-form.php'; ?>
        </form>

    </div>

    <?php require 'includes/footer.php'; ?>
