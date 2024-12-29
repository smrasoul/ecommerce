<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';
require 'includes/user-functions.php';
require 'includes/signup-functions.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
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
$originalUsername = $user['username'];
$originalEmail = $user['email'];

var_dump($user);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $retypePassword = htmlspecialchars($_POST['retypePassword']);

    validateUserForm($user['first_name'], $user['last_name'],  $user['email'], $user['username'], $password);
    if (!($originalEmail == $user['email'])) {
        checkEmailAvailability($user['email'], $conn);
    }
    if (!($originalUsername == $user['username'])) {
        checkUsernameAvailability($user['username'], $conn);
    }
    passwordsMatch($password, $retypePassword);
    $formFeedback = userFeedback();

    if (empty($formFeedback)) {
        $updateSuccess = updateUserInfo($conn, $user_id, $user['first_name'], $user['last_name'], $user['email'], $user['username'], $password);
        if ($updateSuccess) {
            $_SESSION['success_message'] = 'Account information updated successfully.';
            header('Location: /account-info.php');
            exit;
        } else {
            $_SESSION['error_message'] = 'An error occurred while updating your account information.';
        }
    }

}

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">
    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item bg-secondary-subtle">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                   href="account-info.php">Account information</a>
            </li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover"
                   href="orders.php">Orders history</a>
            </li>
            <?php if (hasPermission('view_product', $userPermissions)): ?>
                <li class="list-group-item">
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

    <div class="col-9 border rounded p-4">

        <form method="POST" action="edit-account-info.php">
            <div class="row mb-4">
                <div class="row col-6">
                    <label for="firstName" class="col-4 fw-bold">First Name</label>
                    <div class="col-8">
                        <input type="text"
                               class="form-control <?= isset($formFeedback['firstName']) ? 'is-invalid' : '' ?>"
                               id="firstName" name="firstName" value="<?= $user['first_name'] ?>">
                        <?php if (isset($formFeedback['firstName'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['firstName'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row col-6">
                    <label for="lastName" class="col-4 fw-bold">Last Name</label>
                    <div class="col-8">
                        <input type="text"
                               class="form-control <?= isset($formFeedback['lastName']) ? 'is-invalid' : '' ?>"
                               id="lastName" name="lastName" value="<?= $user['last_name'] ?>">
                        <?php if (isset($formFeedback['lastName'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['lastName'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="row col-6">
                    <label for="email" class="col-4 fw-bold">Email</label>
                    <div class="col-8">
                        <input type="email"
                               class="form-control <?= isset($formFeedback['email']) ? 'is-invalid' : '' ?>"
                               id="email" name="email" value="<?= $user['email'] ?>">
                        <?php if (isset($formFeedback['email'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['email'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row col-6">
                    <label for="username" class="col-4 fw-bold">Username</label>
                    <div class="col-8">
                        <input type="text"
                               class="form-control <?= isset($formFeedback['username']) ? 'is-invalid' : '' ?>"
                               id="username" name="username" value="<?= $user['username'] ?>">
                        <?php if (isset($formFeedback['username'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['username'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="row col-6">
                    <label for="password" class="col-4 fw-bold">Password</label>
                    <div class="col-8">
                        <input type="password"
                               class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                               id="password" name="password">
                        <?php if (isset($formFeedback['password'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row col-6">
                    <label for="retypePassword" class="col-4 fw-bold">Retype Password</label>
                    <div class="col-8">
                        <input type="password"
                               class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                               id="retypePassword" name="retypePassword">
                        <?php if (isset($formFeedback['password'])) : ?>
                            <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">

                <a class="link-dark link-underline-opacity-0 btn btn-outline-danger" href="account-info.php">Cancel</a>

                <button type="submit" class="btn btn-outline-success ms-4">Save</button>
            </div>
        </form>
    </div>

    <?php require 'includes/footer.php'; ?>
