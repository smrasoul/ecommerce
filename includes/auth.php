<?php

function getUserPermissions($user_id, $conn)
{

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

function hasPermission($permission, $userPermissions)
{

    return in_array($permission, $userPermissions ?? []);
}


function checkUserAccess($conn, $requiredPermission = null) {
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
        $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);

        // If a required permission is provided, check for it
        if ($requiredPermission && !hasPermission($requiredPermission, $userPermissions)) {
            header('HTTP/1.1 403 Forbidden');
            echo "You do not have permission to access this page.";
            exit;
        }

        return $userPermissions;

    } else {
        header('HTTP/1.1 403 Forbidden');
        echo "You do not have permission to access this page.";
        exit;
    }
}




