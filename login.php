<?php

require 'includes/init.php';
require 'includes/login-functions.php';

$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validate inputs
    validateLogin($username, $password);

    // Process login
    processLogin($username, $password, $conn);

    $formFeedback = loginFeedback(); // Retrieve and clear feedback

}

$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

require 'includes/header.php';

?>

<div class="container">
    <h2>Login</h2>

    <?php if (isset($flash_message['signup_success'])) : ?>
        <div class="alert alert-success col-4 text-center">
            <p class="mb-0"> <?= $flash_message['signup_success'] ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($flash_message['auth_error'])) : ?>
        <div class="alert alert-danger col-4 text-center">
                <p class="mb-0"><?= $flash_message['auth_error'] ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <div class="form-group mb-2 row">
            <label for="username">Username</label>
            <div class="col-4">
                <input type="text" class="form-control <?= isset($formFeedback['username_error']) ? 'is-invalid' : '' ?>"
                       id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                <?php if (isset($formFeedback['username_error'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['username_error'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group mb-2 row">
            <label for="password">Password</label>
            <div class="col-4">
                <input type="password" class="form-control <?= isset($formFeedback['password_error']) ? 'is-invalid' : '' ?>"
                       id="password" name="password" value="<?= htmlspecialchars($password) ?>">
                <?php if (isset($formFeedback['password_error'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password_error'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
