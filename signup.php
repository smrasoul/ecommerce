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

    $emailErrors = checkEmailAvailability($email, $conn);
    $errors = array_merge($errors, $emailErrors);

    $usernameErrors = checkUsernameAvailability($username, $conn);
    $errors = array_merge($errors, $usernameErrors);

    if (empty($errors)) {
        $signupErrors = signUp($firstName, $lastName, $email, $username, $password, $conn);
        $errors = array_merge($errors, $signupErrors);
    }

    if (empty($errors)) {
        redirect("/login.php");
    }

}

require 'includes/header.php';

?>



    <div class="container">
        <h2>Sign Up</h2>

        <?php if (!empty($errors['flash'])) : ?>
            <div class="alert alert-danger">
                <?= $errors['flash'] ?>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group mb-2 row">
                <label for="firstName">First Name</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($errors['firstName']) ? 'is-invalid' : '' ?>"
                           id="firstName" name="firstName" value="<?= htmlspecialchars($firstName) ?>">
                    <?php if (isset($errors['firstName'])) : ?>
                        <div class="invalid-feedback"><?= $errors['firstName'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="lastName">Last Name</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($errors['lastName']) ? 'is-invalid' : '' ?>"
                           id="lastName" name="lastName" value="<?= htmlspecialchars($lastName) ?>">
                    <?php if (isset($errors['lastName'])) : ?>
                        <div class="invalid-feedback"><?= $errors['lastName'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="email">Email</label>
                <div class="col-4">
                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                           id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <?php if (isset($errors['email'])) : ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="username">Username</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                           id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                    <?php if (isset($errors['username'])) : ?>
                        <div class="invalid-feedback"><?= $errors['username'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="password">Password</label>
                <div class="col-4">
                    <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                           id="password" name="password" value="<?= htmlspecialchars($password) ?>">
                    <?php if (isset($errors['password'])) : ?>
                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>


<?php require 'includes/footer.php'; ?>