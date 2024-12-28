<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';

$conn = getDbConnection();

$userPermissions = getUserPermissions($_SESSION['user_id'], $conn);

// Ensure the user is an admin
if (!hasPermission('view_product', $userPermissions)) {
    header('HTTP/1.1 403 Forbidden');
    $_SESSION['flash']['auth_error'] = "You do not have permission to access this page.";
    header('Location: /login.php');
    exit;
}

// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>

<?php require 'includes/header.php' ?>


<div class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="user-info">
            <span class="username"></span>
            <a href="/logout.php" class="btn btn-outline-secondary">Logout</a>
        </div>
        <div class="avatar">
            <img src="/path/to/avatar.png" alt="User Avatar" width="40">
        </div>
    </div>
</div>

<div id="sidebar" class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/dashboard.php">Dashboard Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/profile-settings.php">Profile Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/product-management.php">Product Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/orders.php">Orders</a>
        </li>
        <?php if (hasPermission('manage_roles', $userPermissions)) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/role-management.php">Role Management</a>
            </li>
        <?php endif; ?>
    </ul>
</div>


<div class="container">
    <h4 class="my-3">Admin Dashboard</h4>

    <?php if (isset($flash_message['success'])) : ?>
        <div class="alert alert-success"><?= $flash_message['success'] ?></div>
    <?php endif; ?>

    <?php if (isset($flash_message['error'])) : ?>
        <div class="alert alert-danger"><?= $flash_message['error'] ?></div>
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
                            <img src="/assets/media/<?= htmlspecialchars($product['photo']) ?>"
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

<?php require 'includes/footer.php'; ?>
