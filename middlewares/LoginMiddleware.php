<?php

function loginFeedback()
{
    $formFeedback = '';
    if (isset($_SESSION['login_errors'])) {
        $formFeedback = $_SESSION['login_errors'];
        unset($_SESSION['login_errors']);
    }
    return $formFeedback;
}

function validateLogin($username, $password) {
    if ($username == '') {
        $_SESSION['login_errors']['username_error'] = "Username is required.";
    }
    if ($password == '') {
        $_SESSION['login_errors']['password_error'] = "Password is required.";
    }
}

function checkLoginStatusMW()
{
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
        header('HTTP/1.1 403 Forbidden');
        echo "You are already logged in.";
        exit;
    }
}



function validateLoginMW()
{
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    validateLogin($username, $password);

    if (!empty($_SESSION['login_errors'])) {
        $formFeedback = loginFeedback();
        renderView('login/login_view', [
            'username' => $username,
            'formFeedback' => $formFeedback,
            'flash_message' => $_SESSION['flash'] ?? ''
        ]);
        exit;
    }

    authenticateUser($username, $password);

    if (isset($_SESSION['flash'])) {

        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);

        renderView('login/login_view', ['flash_message' => $flash_message, 'username' => $username]);
        exit;
    }



}




