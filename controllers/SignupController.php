<?php

require_once 'models/signupModel.php';
require_once 'views/signup_view.php';
require_once 'services/UserValidationService.php';

function showSignupPage($conn){

    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
        header('HTTP/1.1 403 Forbidden');
        echo "You are already logged in.";
        exit;
    }

    $activeForm = 'Signup';
    $formFeedback = '';
    $user['first_name'] = '';
    $user['last_name'] = '';
    $user['email'] = '';
    $user['username'] = '';

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

    renderSignupPage($user, $activeForm, $formFeedback);

}
