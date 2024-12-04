<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

// Fetch products from the database
$conn = get_db_connection();
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($conn);

require 'includes/header.php'; ?>

<h1 class="my-3">Products</h1>

<div class="container">
    <div class="row">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-2 mb-4"> <!-- 6 items per row -->
                    <div class="card">
                        <?php if (!empty($product['photo'])): ?>
                            <img src="/assets/images/<?= htmlspecialchars($product['photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" />
                        <?php else: ?>
                            <img src="/assets/images/default-product.jpg" class="card-img-top" alt="No photo" />
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
