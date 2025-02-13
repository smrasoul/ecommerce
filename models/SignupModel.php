<?php

function signUp($firstName, $lastName, $email, $username, $hashedPassword) {

    global $conn;

    $role_id = 2;

    $insertQuery = "INSERT INTO users (first_name, last_name, email, username, password, role_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'sssssi', $firstName, $lastName, $email, $username, $hashedPassword, $role_id);

    return mysqli_stmt_execute($stmt);

}