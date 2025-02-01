<?php

require_once 'models/LoginModel.php';

function showLoginPage()
{
    renderView('login/login_view');
}

// ------------------------------------------------------------------------------------------------------------

function submitLoginForm() {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    processLogin($username, $password);

}

