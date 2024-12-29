<?php

require 'includes/init.php';
require 'includes/user-functions.php';
require 'includes/order-functions.php';


$userPermissions = checkUserAccess($conn);


$user_id = $_SESSION['user_id'];
var_dump($user_id);

$user = getUserinfo($conn, $user_id);
var_dump($user);

$latestOrder = getLatestOrder($conn, $user_id);
var_dump($latestOrder);

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="src/Account/account-info.php">Account information</a>
            </li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="orders.php">Orders history</a>
            </li>
            <?php if (hasPermission('view_product', $userPermissions)): ?>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="src/Product/view-product.php">Product Management</a></li>
            <?php endif; ?>
            <?php if (hasPermission('manage_user', $userPermissions)): ?>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="manage-user.php">User Management</a></li>
            <?php endif ?>
        </ul>
    </div>
    <div class="col-9 border rounded p-4">


        <div class="row mb-4 border rounded p-4">
            <div class="row mb-3">
                <h5 class="col-3 border-bottom">Account Information</h5>
            </div>
            <div class="row col-6">
                <label for="firstName" class="col-4 fw-bold">First Name</label>
                <div class="col-8">
                    <input type="text" class="form-control-plaintext"
                           id="firstName" name="firstName" readonly value="<?= $user['first_name'] ?>">
                </div>
            </div>

            <div class="row col-6">
                <label for="lastName" class="col-4 fw-bold">Last Name</label>
                <div class="col-8">
                    <input type="text" class="form-control-plaintext"
                           id="lastName" name="lastName" readonly value="<?= $user['last_name'] ?>">
                </div>
            </div>
        </div>


        <div class="row mb-4 border rounded p-4">
            <div class="row mb-3">
                <h5 class="col-2 border-bottom">Latest Order</h5>
            </div>
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
                <tr>
                    <td class="align-content-center"><?= htmlspecialchars($latestOrder['order_number']) ?></td>
                    <td class="align-content-center"><?= htmlspecialchars($latestOrder['date']) ?></td>
                    <td class="align-content-center"><?= htmlspecialchars($latestOrder['payment']) ?></td>
                    <td class="align-content-center"><?= htmlspecialchars($latestOrder['status']) ?></td>
                    <td class="align-content-center"><a href="#" class="btn btn-warning btn-sm">Details</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="border rounded p-4 mb-4 row">
            <div class="row mb-3">
                <h5 class="col-2 border-bottom">Management</h5>
            </div>
            <div class="col-2"></div>
                <a class="col-3 link-dark link-underline-opacity-0 text-light btn btn-primary fw-bold" href="manage-user.php">User Management</a>
            <div class="col-2"></div>
                <a class="col-3 link-dark link-underline-opacity-0 text-light btn btn-primary fw-bold" href="view-product.php">Product Management</a>
            <div class="col-2"></div>
        </div>



    </div>
</div>

<?php require 'includes/footer.php' ?>
