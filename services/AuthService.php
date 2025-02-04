<?php



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




