<?php

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

}




