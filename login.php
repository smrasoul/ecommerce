<?php

require 'includes/init.php';
require 'includes/url.php';
require 'includes/login-functions.php';

$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Step 1: Validate inputs
    $errors = validate_login($username, $password);

    // Step 2: Authenticate user if no validation errors
    if (empty($errors)) {
        $result = authenticate_user($username, $password, $conn);

        // Check if authentication was successful
        if (is_array($result) && isset($result['id'])) {
            login_user($result); // Log the user in
            $_SESSION['permissions'] = get_user_permissions($_SESSION['user_id'], $conn);
            redirect("/index.php");
            exit;
        } else {
            $errors = $result; // Authentication errors
        }
    }
}

require 'includes/header.php';

?>

<div class="container">
    <h2>Login</h2>
    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group mb-2 row">
            <label for="username">Username</label>
            <div class="col-4">
                <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
            </div>
        </div>
        <div class="form-group mb-2 row">
            <label for="password">Password</label>
            <div class="col-4">
                <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
