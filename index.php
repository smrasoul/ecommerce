<?php

require 'includes/init.php';
require 'includes/functions.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);
}

// Fetch products from the database
$products = getAllProducts($conn);

require 'includes/header.php'; ?>

<h1 class="my-4">Products</h1>

<div class="container">
    <div class="row">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <?php $media = fetchMediaByProductId($product['id'], $conn); ?>
                <div class="col-md-2 mb-4"> <!-- 6 items per row -->
                    <div class="card">
                        <?php if (!empty($media)): ?>
                            <img src="/assets/media/<?= htmlspecialchars($media[0]['file_path']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" />
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

<?php require 'includes/footer.php'; ?>
