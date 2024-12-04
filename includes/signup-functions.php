<?php


function validate_signup($username, $password) {

    $errors = array();

    if($username == ''){
        $errors['username_error'] = "username is empty";
    }
    if($password == ''){
        $errors['password_error'] = "password is empty";
    }
    return $errors;
}

function check_username_availability($username, $conn) {

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

function signup($username, $password, $conn) {

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
