<?php

require 'includes/init.php';
require 'src/Signup/Function/signup-function.php';
require 'src/User/Validation/user-validation.php';


if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
    header('HTTP/1.1 403 Forbidden');
    echo "You are already logged in.";
    exit;
}

$activeForm = 'Signup';
$user['first_name'] = '';
$user['last_name'] = '';
$user['email'] = '';
$user['username'] = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $retypePassword = htmlspecialchars($_POST['retypePassword']);

    validateUserForm($user['first_name'], $user['last_name'], $user['email'], $user['username'], $password);
    checkEmailAvailability($user['email'], $conn);
    checkUsernameAvailability($user['username'], $conn);
    passwordsMatch($password, $retypePassword);
    $formFeedback = userFeedback();

    if (empty($formFeedback)) {

        signUp($user['first_name'], $user['last_name'], $user['email'], $user['username'], $password, $conn);
        $_SESSION['flash']['signup_success'] = 'Signed up successfully.';
        redirect('/login.php');

    }

}

require 'includes/View/Layers/header.php';

?>

    <h1 class="my-4">Sign Up</h1>

    <div class="border rounded p-4">

        <?php if (isset($_SESSION['signup_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['signup_failure'] ?>
            </div>
            <?php unset($_SESSION['signup_failure']) ?>
        <?php endif; ?>

        <?php require 'src/User/View/user-form.php'; ?>

    </div>

<?php require 'includes/View/Layers/footer.php'; ?>