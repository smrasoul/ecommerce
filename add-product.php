<?php

require 'includes/init.php';

$conn = getDbConnection();

$userPermissions = checkUserAccess($conn, 'add_product');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];

    // Validation
    validateProduct($name, $price, $photo);
    $formFeedback = productFeedback();

    // If no errors, save the product
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
mysqli_close($conn);

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Add Product</h1>

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

        <?php require 'includes/product-form.php'; ?>

    </div>

</div>

<?php require 'includes/footer.php' ?>
