<?php

require 'includes/init.php';
require 'src/Product/Function/product-Function.php';
require 'src/Product/Validation/product-Validation.php';

$activePage= 'view-product';

$userPermissions = checkUserAccess($conn, 'view_product');

$products = fetchAllProducts($conn);

$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>

<?php require 'includes/View/header.php' ?>

<h1 class="my-4">Admin Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded py-3">

        <?php require 'src/Product/View/product-flash.php' ?>

        <a href="add-product.php" class="btn btn-success mb-3">Add Product</a>

        <?php require 'src/Product/View/product-table.php' ?>

    </div>
</div>

<?php require 'includes/View/footer.php' ?>
