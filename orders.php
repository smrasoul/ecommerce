<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';
require 'includes/order-functions.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);
}

$userId = $_SESSION['user_id'];
$orders = getOrders($userId, $conn);
var_dump($orders);

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="account-info.php">Account information</a>
            </li>
            <li class="list-group-item bg-secondary-subtle">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="orders.php">Orders history</a>
            </li>
            <?php if (hasPermission('view_product', $userPermissions)): ?>
                <li class="list-group-item">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="view-product.php">Product Management</a></li>
            <?php endif; ?>
            <?php if (hasPermission('manage_user', $userPermissions)): ?>
                <li class="list-group-item">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="manage-user.php">User Management</a></li>
            <?php endif ?>
        </ul>
    </div>
    <div class="col-9 border rounded py-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Order Number</th>
                <th>Date</th>
                <th>Payment Information</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="align-content-center"><?= htmlspecialchars($order['order_number']) ?></td>
                        <td class="align-content-center"><?= htmlspecialchars($order['date']) ?></td>
                        <td class="align-content-center"><?= htmlspecialchars($order['payment']) ?></td>
                        <td class="align-content-center"><?= htmlspecialchars($order['status']) ?></td>
                        <td class="align-content-center"><a href="#" class="btn btn-warning btn-sm">Details</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td  colspan="5">No Orders found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'includes/footer.php' ?>
