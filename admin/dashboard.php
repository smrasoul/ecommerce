<?php

session_start();

require '../includes/db.php';
require '../includes/auth.php';

// Ensure the user is an admin
if (!hasPermission('view_product')) {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = getDbConnection();

// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);

?>

<?php require dirname(__DIR__) . '/includes/header.php' ?>

<h4 class="my-3">Admin Dashboard</h4>
<a href="add-product.php" class="btn btn-success mb-3">Add Product</a>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Photo</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <tr >
                <td class="align-content-center"><?= htmlspecialchars($product['id']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($product['name']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($product['price']) ?></td>
                <td class="align-content-center">
                    <?php if ($product['photo']): ?>
                        <img src="/assets/images/<?= htmlspecialchars($product['photo']) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>" width="50">
                    <?php else: ?>
                        No photo
                    <?php endif; ?>
                </td>
                <td class="align-content-center">
                    <a href="edit-product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete-product.php?id=<?= $product['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this product?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No products found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php require dirname(__DIR__) . '/includes/footer.php' ?>
