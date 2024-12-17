<?php


function validateSignup($firstName, $lastName, $email, $username, $password) {
    $errors = array();

    if ($firstName == '') {
        $errors['firstName'] = "First Name is required";
    }

    if ($lastName == '') {
        $errors['lastName'] = "Last Name is required";
    }

    if ($email == '') {

        $errors['email'] = "Email is required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['email'] = "Invalid email format"; }

    if ($username == '') {
        $errors['username'] = "Username is required";
    }

    if ($password == '') {
        $errors['password'] = "Password is required";
    }

    return $errors;
}


function checkEmailAvailability($email, $conn) {
    $errors = array();

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $errors['email'] = "This email is already taken.";
    }

    return $errors;
}


function checkUsernameAvailability($username, $conn) {
    $errors = array();

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $errors['username'] = "This username is already taken.";
    }

    return $errors;
}


function signUp($firstName, $lastName, $email, $username, $password, $conn) {
    $errors = array();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role_id = 2;

    $insertQuery = "INSERT INTO users (first_name, last_name, email, username, password, role_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'sssssi', $firstName, $lastName, $email, $username, $hashedPassword, $role_id);

    if (!mysqli_stmt_execute($stmt)) {
        $errors['flash'] = 'An unexpected error occurred. Please try again later.';
    }

    return $errors;
}

