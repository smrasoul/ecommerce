<?php

require 'includes/init.php';
require 'src/Product/Function/product-function.php';


$products = fetchAllProducts($conn);


$productsWithMedia = getProductsWithMedia($conn, $products);

require 'includes/View/header.php'; ?>

<h1 class="my-4">Products</h1>

<div class="container">
    <div class="row">
        <?php if ($productsWithMedia): ?>
            <?php foreach ($productsWithMedia as $product): ?>
                <div class="col-md-2 mb-4">
                    <div class="card">
                        <?php if ($product['media']): ?>
                            <img src="/assets/media/<?= htmlspecialchars($product['media']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" />
                        <?php else: ?>
                            <img src="/assets/images/default_product.png" class="card-img-top" alt="No photo" />
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text">$<?= htmlspecialchars($product['price']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'includes/View/footer.php'; ?>
