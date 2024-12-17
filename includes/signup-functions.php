<?php


function validateSignup($firstName, $lastName, $email, $username, $password) {

    $errors = array();

    if($firstName == ''){
        $errors[] = "First Name is required";
    }

    if($lastName == ''){
        $errors[] = "Last Name is required";
    }

    if($email == ''){
        $errors[] = "Email is required";
    }

    if($username == ''){
        $errors['username_error'] = "username is empty";
    }
    if($password == ''){
        $errors['password_error'] = "password is empty";
    }
    return $errors;
}

function checkEmailAvailability($email, $conn) {

    $errors = array();

    $query = "SELECT * 
                  FROM users
                  WHERE email = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);  // 's' indicates the string parameter
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $email_check = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($email_check && $email_check['email'] === $email){
        $errors['email_availability_error'] = "Email is already taken.";
    };

    return $errors;

}

function checkUsernameAvailability($username, $conn) {

    $errors = array();

    $query = "SELECT * 
                  FROM users
                  WHERE username = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);  // 's' indicates the string parameter
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $username_check = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($username_check && $username_check['username'] === $username){
        $errors['username_availability_error'] = "username is already taken.";
    };

    return $errors;

}

function signUp($username, $password, $conn) {

    $errors = array();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role_id = 2;
    $insertQuery = "INSERT INTO users 
                            (username, password, role_id)
                            VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'ssi', $username, $hashedPassword, $role_id);
    if(! mysqli_stmt_execute($stmt)){
        $errors['signup_error'] = 'an error occurred while trying to signup';
    }
    return $errors;
}
