<?php

function getUserinfo ($conn, $user_id) {

    $query = "SELECT first_name, last_name, email, username FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $user = mysqli_fetch_assoc($result);
}

function updateUserInfo($conn, $firstName, $lastName, $email, $username, $user_id) {


    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $firstName, $lastName, $email, $username, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['flash']['edit_user_success'] = 'Your account has been updated.';
        redirect('/account-info.php');
    }else {
        $_SESSION['edit_user_failed'] = 'Your account was not updated.';
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

function processNewRole($conn, $roleName)
{
//    validateRole($roleName);
    $newRoleId = createRole($roleName, $conn);

    if ($newRoleId) {
        $_SESSION['success_message'] = "Role '$roleName' created successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to create role.";
    }
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

function processNewRolePermissions($roleId, $permissionIds, $conn)
{
    if(deleteRolePermissions($roleId, $conn)){
        if (assignPermissionsToRole($roleId, $permissionIds, $conn)) {
            $_SESSION['success_message'] = "Permissions assigned successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to assign permissions.";
        }
    } else {
        $_SESSION['error_message'] = "Failed to assign permissions.";
    }
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



function getUserAndRoles($conn)
{
    $query = "SELECT roles.name AS role_name, users.username , users.id
              FROM roles
              JOIN users
              ON roles.id = users.role_id;";

    $result = mysqli_query($conn, $query);
    return $users_roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getRolePermissions($conn) {
    $query = "SELECT role_permissions.role_id, GROUP_CONCAT(role_permissions.permission_id SEPARATOR ', ') AS permission_id
              FROM role_permissions
              GROUP BY role_permissions.role_id;";

    $result = mysqli_query($conn, $query);
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $rolePermissions = [];
    // Convert permissions to array
    foreach ($output as $rolePermission) {
        $rolePermission['permission_id'] = explode(', ', $rolePermission['permission_id']);
        $rolePermissions[] = $rolePermission;
    }

    return $rolePermissions;
}

function updatePassword($conn, $newPassword, $userId ){

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $hashedPassword, $userId);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['flash']['edit_user_success'] = "Your password has been updated.";
        redirect('/account-info');
    }else{
        $_SESSION['password_failure'] = "Failed to update password.";
    }



}






