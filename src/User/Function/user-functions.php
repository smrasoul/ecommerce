<?php

function getUserinfo ($conn, $user_id) {

    $query = "SELECT first_name, last_name, email, username FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $user = mysqli_fetch_assoc($result);
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





