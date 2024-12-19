<?php

function getUserinfo ($conn, $user_id) {

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $user = mysqli_fetch_assoc($result);
}

function updateUserInfo($conn, $user_id, $firstName, $lastName, $email, $username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ?, password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $firstName, $lastName, $email, $username, $hashedPassword, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

