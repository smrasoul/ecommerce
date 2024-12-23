<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';
require 'includes/user-functions.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);
} else {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$user_id = $_SESSION['user_id'];
var_dump($user_id);

$user = getUserinfo($conn, $user_id);
var_dump($user);



?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item bg-secondary-subtle">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="account-info.php">Account information</a>
            </li>
            <li class="list-group-item">
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

    <div class="col-9 border rounded p-4">

        <div class="row mb-4">
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

        <div class="row mb-4">
            <div class="row col-6">
                <label for="email" class="col-4 fw-bold">Email</label>
                <div class="col-8">
                    <input type="email" class="form-control-plaintext"
                           id="email" name="email" readonly value="<?= $user['email']  ?>">
                </div>
            </div>
            <div class="row col-6">
                <label for="username" class="col-4 fw-bold">Username</label>
                <div class="col-8">
                    <input type="text" class="form-control-plaintext"
                           id="username" name="username" readonly value="<?= $user['username'] ?>">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">

                <a class="link-dark link-underline-opacity-0 btn btn-warning" href="edit-account-info.php">Edit information</a>

        </div>

    </div>
</div>

<?php require 'includes/footer.php' ?>
