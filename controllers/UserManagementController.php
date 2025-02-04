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


