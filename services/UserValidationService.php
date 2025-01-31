<?php

function validateUserForm($firstName, $lastName, $email, $username, $password = false) {


    if ($firstName == '') {
        $_SESSION['user_errors']['firstName'] = "First Name is required";
    }

    if ($lastName == '') {
        $_SESSION['user_errors']['lastName'] = "Last Name is required";
    }

    if ($email == '') {

        $_SESSION['user_errors']['email'] = "Email is required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['user_errors']['email'] = "Invalid email format";
    }

    if ($username == '') {
        $_SESSION['user_errors']['username'] = "Username is required";
    }

    if ($password !== false) {
        if ($password == '') {
            $_SESSION['user_errors']['password'] = "Password is required";
        }
    }
}




function userFeedback(){
    $formFeedback = '';
    if(isset($_SESSION['user_errors'])) {
        $formFeedback = $_SESSION['user_errors'];
        unset($_SESSION['user_errors']);
    }
    return $formFeedback;
}



function passwordsMatch($password, $retypePassword) {
    if(!($password === $retypePassword)) {
        $_SESSION['user_errors']['password'] = "Passwords do not match.";
        echo 'passwords do not match.';
    }
}


function validatePasswordForm ($currentPassword, $newPassword) {
    if($currentPassword == '') {
        $_SESSION['user_errors']['current_password'] = "Current Password is required";
    }
    if($newPassword == '') {
        $_SESSION['user_errors']['password'] = "New Password is required";
    }
}




// Login Validations:

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

