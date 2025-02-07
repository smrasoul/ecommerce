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
                            </div>
                            <a class="my-2 mx-5 btn btn-primary" href="../product/<?= $product['id'] ?>">View</a>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>