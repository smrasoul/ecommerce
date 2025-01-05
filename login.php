<?php

require 'includes/init.php';
require 'src/Login/Function/login-functions.php';
require 'src/Login/Validation/login-validation.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    header('HTTP/1.1 403 Forbidden');
    echo "You are already logged in.";
    exit;
}

$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);


    validateLogin($username, $password);


    processLogin($username, $password, $conn);

    $formFeedback = loginFeedback();

}

$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

require 'includes/View/Layers/header.php';

?>


    <h1 class="my-4">Login</h1>
    <div class="">

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

    <?php require 'src/Login/View/login-form.php'; ?>

    </div>



<?php require 'includes/View/Layers/footer.php'; ?>
