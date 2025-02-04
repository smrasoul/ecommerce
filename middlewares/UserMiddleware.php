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

function verifyUserMW()
{
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {

        $user_Id = $_SESSION['user_id'];
        $result = checkUserExistence($user_Id);

        if (mysqli_num_rows($result) === 0) {

            header('HTTP/1.1 403 Forbidden');
            echo "You do not have permission to access this page.";
        }
    }
}

function checkPermissionsMW()
{

        $user_id = $_SESSION['user_id'];
        $userPermissions = getUserPermissions($user_id);

        // Set global variables for use in controllers and views
        $GLOBALS['canViewProduct'] = hasPermission('view_product', $userPermissions);
        $GLOBALS['canManageUser'] = hasPermission('manage_user', $userPermissions);
}



