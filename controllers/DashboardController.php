<?php

require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';

function showDashboardPage(){

    $activePage = 'dashboard';
    $user_id = $_SESSION['user_id'];

    $userPermissions = getUserPermissions($user_id);
    $canViewProduct = hasPermission('view_product', $userPermissions);
    $canManageUser = hasPermission('manage_user', $userPermissions);
    $user = getUserInfo($user_id);
    $latestOrder = getLatestOrder($user_id);

    renderView('dashboard/dashboard_view', ['activePage' => $activePage,
        'canViewProduct' => $canViewProduct,
        'canManageUser' => $canManageUser,
        'user' => $user,
        'latestOrder' => $latestOrder]);

}