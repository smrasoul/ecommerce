<?php

require_once 'models/LoginModel.php';

function showLoginPage()
{

    $flash_message = '';

    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    renderView('login/login_view', ['flash_message' => $flash_message]);
}

// ------------------------------------------------------------------------------------------------------------

function submitLoginForm() {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    processLogin($username, $password);

}

