<h1 class="my-4">Add Product</h1>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded py-3">

        <?php if (isset($_SESSION['product_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['product_failure'] ?>
            </div>
            <?php unset($_SESSION['product_failure']) ?>
        <?php endif; ?>

        <?php require 'views/product/product-form.php'; ?>

    </div>

</div>