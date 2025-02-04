<h1 class="my-4">Admin Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded py-3">

        <?php require 'views/product/product-flash.php' ?>

        <a href="add-product" class="btn btn-success mb-3">Add Product</a>

        <?php require 'views/product/product-table.php' ?>

    </div>
</div>