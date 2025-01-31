<?php

require_once 'models/LoginModel.php';
require_once 'services/UserValidationService.php';

function showLoginPage()
{
    renderView('login/login_view');
}

// ------------------------------------------------------------------------------------------------------------

function submitLoginForm()
{

    $username = '';
    $formFeedback = '';
    $flash_message = '';

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

//    validateLogin($username, $password);
//    $formFeedback = loginFeedback();
    processLogin($username, $password);

    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    renderView('login/login_view', [
        'username' => $username,
        'formFeedback' => $formFeedback,
        'flash_message' => $flash_message
    ]);
}

