<?php

require_once 'models/LoginModel.php';
require_once 'services/UserValidationService.php';

$formFeedback ='';
$flash_message = '';
$username ='';

function showLoginPage($flash_message, $username, $formFeedback)
{
    renderView('login/login_view', [
        'flash_message' => $flash_message,
        'username' => $username,
        'formFeedback' => $formFeedback
    ]);
}

// ------------------------------------------------------------------------------------------------------------


function processLogin($username, $password, $conn) {
    if (empty($_SESSION['login_errors'])) {
        $user = authenticateUser($username, $password, $conn); // Check if authentication was successful
        if ($user) {
            loginUser($user); // Log the user in
            redirect("/dashboard.php");
            exit;
        }
    }
}

function showLoginPageeeee($conn) {

    checkLoginStatus();
    $username = '';
    $formFeedback = '';

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

    // Pass $username to the View
    renderLoginPage($flash_message, $username, $formFeedback);
}

