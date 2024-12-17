<?php

require 'includes/init.php';
require 'includes/url.php';
require 'includes/signup-functions.php';

$firstName = '';
$lastName = '';
$email = '';
$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $errors = validateSignup($firstName, $lastName, $email, $username, $password);

    if(empty($errors)) {
        $errors = checkEmailAvailability($email, $conn);
    }

    if (empty($errors)) {
        $errors = checkUsernameAvailability($username, $conn);
    }

    if (empty($errors)) {
        $errors = signUp($username, $password, $conn);
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
            <label for="firstName">First name</label>
            <div class="col-4">
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $firstName ?>">
            </div>
        </div>
        <div class="form-group mb-2 row">
            <label for="lastName">Last name</label>
            <div class="col-4">
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $lastName ?>">
            </div>
        </div>
        <div class="form-group mb-2 row">
            <label for="email">Email</label>
            <div class="col-4">
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
            </div>
        </div>
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