<?php

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

function passwordsMatch($password, $retypePassword) {
    if(!($password === $retypePassword)) {
        $_SESSION['user_errors']['password'] = "Passwords do not match.";
        echo 'passwords do not match.';
    }
}

