<?php


function validateLogin($username, $password)
{
    $errors = array();

    if ($username == '') {
        $errors['username_error'] = "Username is required.";
    }
    if ($password == '') {
        $errors['password_error'] = "Password is required.";
    }

    return $errors;
}

function authenticateUser($username, $password, $conn) {
    $errors = array();

    // Fetch user record
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        $errors['login_error'] = "Invalid username or password.";
    } else {
        // Verify password
        if (!password_verify($password, $user['password'])) {
            $errors['login_error'] = "Invalid username or password.";
        }
    }

    if (empty($errors)) {
        return $user; // Return user details if authenticated
    }

    return $errors;
}

function loginUser($user) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role_id'] = $user['role_id']; // Admin or User role
}

function getUserPermissions($user_id, $conn) {
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


