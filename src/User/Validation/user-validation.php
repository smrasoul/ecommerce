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


function checkEmailAvailability($email, $conn) {


    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_SESSION['user_errors']['email'] = "This email is already taken.";
    }
}


function checkUsernameAvailability($username, $conn) {

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_SESSION['user_errors']['username'] = "This username is already taken.";
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

function validateRole($roleName)
{
    if($roleName == '') {
        $_SESSION['user_errors']['role'] = "Role is required";
    } else {
        $query = "SELECT * FROM roles where role = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $roleName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $_SESSION['user_errors']['role'] = "This role is already taken.";
        }
    }
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

function validatePasswords($currentPassword, $newPassword, $user_id, $conn)
{

    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pass = mysqli_fetch_assoc($result);

    if ($currentPassword !=='' && !password_verify($currentPassword, $pass['password'])) {
        $_SESSION['user_errors']['current_password'] = "Current password is incorrect";
    }

    if (password_verify($newPassword, $pass['password'])) {
        $_SESSION['user_errors']['password'] = "You're already using this password.";
    }
}

