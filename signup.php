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

    validateSignup($firstName, $lastName, $email, $username, $password);
    checkEmailAvailability($email, $conn);
    checkUsernameAvailability($username, $conn);
    $formFeedback = signupFeedback();

    if(empty($formFeedback)) {

        signUp($firstName, $lastName, $email, $username, $password, $conn);
        $_SESSION['signup_success'] = 'Signed up successfully.';
        redirect('/login.php');

    };

}

require 'includes/header.php';

?>



    <div class="container">
        <h2>Sign Up</h2>

        <?php if (isset($signupFailure)) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['signup_failure'] ?>
            </div>
            <?php unset($_SESSION['signup_failure']) ?>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="form-group mb-2 row">
                <label for="firstName">First Name</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($formFeedback['firstName']) ? 'is-invalid' : '' ?>"
                           id="firstName" name="firstName" value="<?= htmlspecialchars($firstName) ?>">
                    <?php if (isset($formFeedback['firstName'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['firstName'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="lastName">Last Name</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($formFeedback['lastName']) ? 'is-invalid' : '' ?>"
                           id="lastName" name="lastName" value="<?= htmlspecialchars($lastName) ?>">
                    <?php if (isset($formFeedback['lastName'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['lastName'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="email">Email</label>
                <div class="col-4">
                    <input type="email" class="form-control <?= isset($formFeedback['email']) ? 'is-invalid' : '' ?>"
                           id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <?php if (isset($formFeedback['email'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['email'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="username">Username</label>
                <div class="col-4">
                    <input type="text" class="form-control <?= isset($formFeedback['username']) ? 'is-invalid' : '' ?>"
                           id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                    <?php if (isset($formFeedback['username'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['username'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mb-2 row">
                <label for="password">Password</label>
                <div class="col-4">
                    <input type="password" class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                           id="password" name="password" value="<?= htmlspecialchars($password) ?>">
                    <?php if (isset($formFeedback['password'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>


<?php require 'includes/footer.php'; ?>