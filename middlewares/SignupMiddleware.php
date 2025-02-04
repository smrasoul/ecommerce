<?php

function validateSignupMW(){

    $user['first_name'] = htmlspecialchars($_POST['firstName'] ?? '');
    $user['last_name'] = htmlspecialchars($_POST['lastName'] ?? '');
    $user['email'] = htmlspecialchars($_POST['email'] ?? '');
    $user['username'] = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $retypePassword = htmlspecialchars($_POST['retypePassword'] ?? '');

    validateUserForm($user['first_name'], $user['last_name'], $user['email'], $user['username'], $password);
    checkEmailAvailability($user['email']);
    checkUsernameAvailability($user['username']);
    passwordsMatch($password, $retypePassword);

    if(!empty($_SESSION['user_errors'])){
        $formFeedback = userFeedback();
        $activeForm = 'Signup';
        renderView('signup_view', ['formFeedback' => $formFeedback,'activeForm' => $activeForm, 'user' => $user]);
        exit;
    }

}
