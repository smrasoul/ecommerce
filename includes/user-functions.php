<?php

function getUserinfo ($conn, $user_id) {

    $query = "SELECT first_name, last_name, email, username FROM users WHERE id = ?";
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

function passwordsMatch($password, $retypePassword) {
    if(!($password === $retypePassword)) {
        $_SESSION['user_errors']['password'] = "Passwords do not match.";
        echo 'passwords do not match.';
    }
}

function createRole($roleName, $conn) {
    $query = "INSERT INTO roles (name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $roleName);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($conn) > 0) {
        return mysqli_insert_id($conn); // Return the new role ID
    }

    return false; // Return false if insertion failed
}


function deleteRolePermissions($roleId, $conn)
{
    $query = "DELETE FROM role_permissions WHERE role_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $roleId);
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

function assignPermissionsToRole($roleId, $permissionIds, $conn) {
    $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)";

    foreach ($permissionIds as $permissionId) {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $roleId, $permissionId);
        mysqli_stmt_execute($stmt);
    }

    return true; // Indicate successful assignment
}

function changeUserRole($userId, $newRoleId, $conn) {
    $query = "UPDATE users SET role_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $newRoleId, $userId);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn) > 0; // Return true if the update succeeded
}

function getRoles($conn)
{
    $query = "SELECT * FROM roles";
    $result = mysqli_query($conn, $query);
    return $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPermissions ($conn){
    $query = "SELECT * FROM permissions";
    $result = mysqli_query($conn, $query);
    return $permissions = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUsers ($conn) {
    $query = "SELECT id, username, role_id FROM users";
    return mysqli_query($conn, $query);
}

function getUsernameAndEmail ($conn, $user_id){
    $query = "SELECT username, email FROM users";

}

function getUserAndRoles($conn)
{
    $query = "SELECT roles.name AS role_name, users.username , users.id
              FROM roles
              JOIN users
              ON roles.id = users.role_id;";

    $result = mysqli_query($conn, $query);
    return $users_roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
}





