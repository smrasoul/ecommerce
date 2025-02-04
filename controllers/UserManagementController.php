<?php

function showUserManagementPage(){

    $roles = getRoles();
    $permissions = getPermissions();
    $users = getUsers();
    $users_roles = getUserAndRoles();

    // Get permissions for each role
    $rolePermissions = getAllRolePermissions($roles);

    $activePage = 'user-management';

    renderView('user_management/user_management_view', [
        'roles' => $roles,
        'permissions' => $permissions,
        'users' => $users,
        'activePage' => $activePage,
        'usersRoles' => $users_roles,
        'rolePermissions' => $rolePermissions
    ]);
}

function submitUserManagementForm(){

    if (isset($_POST['create_role'])) {

        $roleName = htmlspecialchars(trim($_POST['role_name']));
        processNewRole($roleName);

    }

    if (isset($_POST['assign_permissions'])) {

        $roleId = $_POST['role_id'];
        $permissionIds = $_POST['permission'] ?? [];
        processNewRolePermissions($roleId, $permissionIds);

    }

    if(isset($_POST['assign_role'])) {

        $userId = $_POST['user_id'];
        $newRoleId = $_POST['role_id'];
        changeUserRole($userId, $newRoleId);

    }
}


