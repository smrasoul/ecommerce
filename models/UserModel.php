<?php

function getUserinfo ($user_id) {

    global $conn;

    $query = "SELECT first_name, last_name, email, username FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $user = mysqli_fetch_assoc($result);
}

function checkEmailAvailability($email) {

    global $conn;


    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_SESSION['user_errors']['email'] = "This email is already taken.";
    }
}


function checkUsernameAvailability($username) {

    global $conn;

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $_SESSION['user_errors']['username'] = "This username is already taken.";
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

function checkUserExistence($user_Id){

    global $conn;

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_Id);
    mysqli_stmt_execute($stmt);
    return $result = mysqli_stmt_get_result($stmt);
}

function getUserPermissions($user_id)
{
    global $conn;

    $query = "
        SELECT p.name AS permission_name
        FROM permissions p
        INNER JOIN role_permissions rp ON p.id = rp.permission_id
        INNER JOIN roles r ON rp.role_id = r.id
        INNER JOIN users u ON u.role_id = r.id
        WHERE u.id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $permissions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $permissions[] = $row['permission_name'];
    }
    return $permissions;
}


