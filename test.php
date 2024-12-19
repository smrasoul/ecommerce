<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);
}

// Ensure the user is an admin
//if (!hasPermission('view_product', $userPermissions)) {
//    header('HTTP/1.1 403 Forbidden');
//    echo "You do not have permission to access this page.";
//    exit;
//}



// Fetch all products
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

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
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="orders-history.php">Orders history</a>
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

        <div class="form-group mb-2 row">
            <label for="firstName">First Name</label>
            <div class="col-6">
                <input type="text" class="form-control <?= isset($formFeedback['firstName']) ? 'is-invalid' : '' ?>"
                       id="firstName" readonly name="firstName" value="<?= htmlspecialchars($firstName) ?>">
                <?php if (isset($formFeedback['firstName'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['firstName'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group mb-2 row">
            <label for="lastName">Last Name</label>
            <div class="col-6">
                <input type="text" class="form-control <?= isset($formFeedback['lastName']) ? 'is-invalid' : '' ?>"
                       id="lastName" name="lastName" value="<?= htmlspecialchars($lastName) ?>">
                <?php if (isset($formFeedback['lastName'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['lastName'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group mb-2 row">
            <label for="email">Email</label>
            <div class="col-6">
                <input type="email" class="form-control <?= isset($formFeedback['email']) ? 'is-invalid' : '' ?>"
                       id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                <?php if (isset($formFeedback['email'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['email'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group mb-2 row">
            <label for="username">Username</label>
            <div class="col-6">
                <input type="text" class="form-control <?= isset($formFeedback['username']) ? 'is-invalid' : '' ?>"
                       id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                <?php if (isset($formFeedback['username'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['username'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group mb-2 row">
            <label for="password">Password</label>
            <div class="col-6">
                <input type="password" class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                       id="password" name="password" value="<?= htmlspecialchars($password) ?>">
                <?php if (isset($formFeedback['password'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-warning ">
                Edit information
            </button>
        </div>

    </div>
</div>

<?php require 'includes/footer.php' ?>
