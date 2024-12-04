<?php

require 'includes/init.php';
require 'includes/url.php';
require 'includes/signup-functions.php';

$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $errors = validate_signup($username, $password);

    if (empty($errors)) {
        $errors = check_username_availability($username, $conn);
    }

    if (empty($errors)) {
        $errors = signup($username, $password, $conn);
    }

    if(empty($errors)){
        redirect("/dashboard.php");
    }
}

require 'includes/header.php';

?>



<div class="container">
    <h2>Sign Up</h2>
    <?php if (! empty($errors)) : ?>
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
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>