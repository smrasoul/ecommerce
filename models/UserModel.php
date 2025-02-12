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

function validatePasswords($currentPassword, $newPassword, $user_id)
{

    global $conn;

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

function updateUser($firstName, $lastName, $email, $username, $user_id) {

    global $conn;

    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $firstName, $lastName, $email, $username, $user_id);

    return mysqli_stmt_execute($stmt);

}


function getUsers (){

    global $conn;

    $query = "SELECT id, username, role_id FROM users";
    return mysqli_query($conn, $query);
}


function getRoles()
{

    global $conn;

    $query = "SELECT * FROM roles";
    $result = mysqli_query($conn, $query);
    return $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPermissions (){

    global $conn;

    $query = "SELECT * FROM permissions";
    $result = mysqli_query($conn, $query);
    return $permissions = mysqli_fetch_all($result, MYSQLI_ASSOC);
}



function getUserAndRoles() {
    global $conn;

    $query = "SELECT id, role_id FROM users";
    $result = mysqli_query($conn, $query);
    $userRoles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $userRoles;
}



function getRolePermissions($roleId) {
    global $conn;

    $query = "SELECT permission_id FROM role_permissions WHERE role_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $roleId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rolePermissions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rolePermissions[] = $row['permission_id'];
    }
    return $rolePermissions;
}

function getAllRolePermissions($roles) {
    $rolePermissions = [];
    foreach ($roles as $role) {
        $rolePermissions[$role['id']] = getRolePermissions($role['id']);
    }
    return $rolePermissions;
}

function createRole($roleName) {

    global $conn;

    $query = "INSERT INTO roles (name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $roleName);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($conn) > 0) {
        return mysqli_insert_id($conn); // Return the new role ID
    }

    return false; // Return false if insertion failed
}

function processNewRole($roleName)
{

    global $conn;

//    validateRole($roleName);
    $newRoleId = createRole($roleName, $conn);

    if ($newRoleId) {
        $_SESSION['success_message'] = "Role '$roleName' created successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to create role.";
    }
    redirect('/user-management');
}

function deleteRolePermissions($roleId)
{

    global $conn;

    $query = "DELETE FROM role_permissions WHERE role_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $roleId);
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

function assignPermissionsToRole($roleId, $permissionIds) {

    global $conn;

    $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)";

    foreach ($permissionIds as $permissionId) {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $roleId, $permissionId);
        mysqli_stmt_execute($stmt);
    }

    return true;
}

function processNewRolePermissions($roleId, $permissionIds)
{

    global $conn;

    if(deleteRolePermissions($roleId)){
        if (assignPermissionsToRole($roleId, $permissionIds)) {
            $_SESSION['success_message'] = "Permissions assigned successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to assign permissions on assign.";
        }
    } else {
        $_SESSION['error_message'] = "Failed to assign permissions on delete.";
    }
    redirect('/user-management');
}

function changeUserRole($userId, $newRoleId) {

    global $conn;

    $query = "UPDATE users SET role_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $newRoleId, $userId);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success_message'] = "Signup role updated successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to update user role.";
    }
    redirect('/user-management');
}


function updatePassword($password, $userId ){

    global $conn;

    $query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $password, $userId);

    return mysqli_stmt_execute($stmt);

}



