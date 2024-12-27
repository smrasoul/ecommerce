<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';
require 'includes/product-functions.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);

    if (!hasPermission('view_product', $userPermissions)) {
        header('HTTP/1.1 403 Forbidden');
        echo "You do not have permission to access this page.";
        exit;
    }

} else {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}


$products = fetchAllProducts($conn);

$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Admin Dashboard</h1>

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

        <?php if (isset($flash_message['product_success'])) : ?>
            <div class="alert alert-success col-4 text-center">
                <p class="mb-0"> <?= $flash_message['product_success'] ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($flash_message['delete_failure'])) : ?>
            <div class="alert alert-danger col-4 text-center">
                <p class="mb-0"> <?= $flash_message['delete_failure'] ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($flash_message['delete_success'])) : ?>
            <div class="alert alert-success col-4 text-center">
                <p class="mb-0"> <?= $flash_message['delete_success'] ?></p>
            </div>
        <?php endif; ?>


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
                    <tr>
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

    </div>
</div>

<?php require 'includes/footer.php' ?>
