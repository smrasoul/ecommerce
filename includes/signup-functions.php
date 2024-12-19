<?php


function validateUser($firstName, $lastName, $email, $username, $password) {


    if ($firstName == '') {
       $_SESSION['user_errors']['firstName'] = "First Name is required";
    }

    if ($lastName == '') {
        $_SESSION['user_errors']['lastName'] = "Last Name is required";
    }

    if ($email == '') {

        $_SESSION['user_errors']['email'] = "Email is required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['user_errors']['email'] = "Invalid email format"; }

    if ($username == '') {
        $_SESSION['user_errors']['username'] = "Username is required";
    }

    if ($password == '') {
        $_SESSION['user_errors']['password'] = "Password is required";
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


function signUp($firstName, $lastName, $email, $username, $password, $conn) {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role_id = 2;

    $insertQuery = "INSERT INTO users (first_name, last_name, email, username, password, role_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'sssssi', $firstName, $lastName, $email, $username, $hashedPassword, $role_id);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['signup_failure'] = 'An error occurred while trying to sign up.';
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
