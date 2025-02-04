<?php

require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';

function showDashboardPage(){

    $activePage = 'dashboard';
    $user_id = $_SESSION['user_id'];
    $user = getUserInfo($user_id);
    $latestOrder = getLatestOrder($user_id);

    renderView('dashboard/dashboard_view', ['activePage' => $activePage,
        'canViewProduct' => $GLOBALS['canViewProduct'],
        'canManageUser' => $GLOBALS['canManageUser'],
        'user' => $user,
        'latestOrder' => $latestOrder]);

}