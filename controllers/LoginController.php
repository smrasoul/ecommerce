<?php

require_once 'models/LoginModel.php';

function showLoginPage()
{

    renderView('login/login_view');
}

// ------------------------------------------------------------------------------------------------------------

function submitLoginForm()
{

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $user = getUserInfoByUsername($username);

    $passwordVerify = verifyPassword($password, $user['password'] ?? '') ?? false;


    if ($passwordVerify) {
        loginUser($user);
        redirect("/user/dashboard");
    } else {
        setFlashMessage(['login' => $passwordVerify]);
        renderView('login/login_view', ['username' => $username]);
    }

}

