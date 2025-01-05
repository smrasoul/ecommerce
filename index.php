<?php

require 'includes/init.php';
require 'src/Product/Function/product-function.php';


$products = fetchAllProductDetails($conn);
//var_dump($products);

require 'includes/View/Layers/header.php'; ?>

<h1 class="my-4">Products</h1>

<div class="container">
    <div class="row">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-2 mb-4">
                    <div class="card">
                        <?php if ($product['main_image']): ?>
                            <img src="/assets/media/<?= htmlspecialchars($product['main_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" />
                        <?php else: ?>
                            <img src="/assets/images/default_product.png" class="card-img-top" alt="No photo" />
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text">$<?= htmlspecialchars($product['price']) ?></p>
                            <ul class="card-text no-bullets">
                                <?php foreach ($product['categories'] as $category): ?>
                                <li>
                                    <?= htmlspecialchars($category) ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'includes/View/Layers/footer.php'; ?>
