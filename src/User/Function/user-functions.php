<?php

function getUserinfo ($conn, $user_id) {

    $query = "SELECT first_name, last_name, email, username FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $user = mysqli_fetch_assoc($result);
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

    return true;
}

function processNewRolePermissions($roleId, $permissionIds, $conn)
{
    if(deleteRolePermissions($roleId, $conn)){
        if (assignPermissionsToRole($roleId, $permissionIds, $conn)) {
            $_SESSION['success_message'] = "Permissions assigned successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to assign permissions on assign.";
        }
    } else {
        $_SESSION['error_message'] = "Failed to assign permissions on delete.";
    }
}

function changeUserRole($userId, $newRoleId, $conn) {
    $query = "UPDATE users SET role_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $newRoleId, $userId);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn) > 0; // Return true if the update succeeded
}




function updatePassword($conn, $newPassword, $userId ){

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $hashedPassword, $userId);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['flash']['edit_user_success'] = "Your password has been updated.";
        redirect('/account_info-info');
    }else{
        $_SESSION['password_failure'] = "Failed to update password.";
    }

}

function getRolePermissions($conn, $role) {
    $query = "SELECT * from role_permissions WHERE role_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $rolePermissions = [];
    foreach ($output as $row) {
        $role_id = $row['role_id'];
        if (!isset($rolePermissions[$role_id])) {
            $rolePermissions[$role_id] = [];
        }
        $rolePermissions[$role_id][] = $row['permission_id'];
    }
    return $rolePermissions;
}



function checkRole($conn, $getRoleId) {
    $query = "SELECT * FROM roles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $getRoleId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        $_SESSION['error_message'] = 'No such role exists.';
    }
}





