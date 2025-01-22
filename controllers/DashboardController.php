<?php

require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';
require_once 'views/dashboard/dashboard_view.php';

function showDashboard($conn) {
    // Check user permissions
    $userPermissions = checkUserAccess($conn);

    // Fetch user info
    $user_id = $_SESSION['user_id'];
    $user = getUserInfo($conn, $user_id);

    // Fetch latest order
    $latestOrder = getLatestOrder($conn, $user_id);

    // Determine the active page
    $activePage = 'dashboard'; // This can be dynamic based on the current page

    // Check permissions for sidebar links
    $canViewProduct = hasPermission('view_product', $userPermissions);
    $canManageUser = hasPermission('manage_user', $userPermissions);

    // Render the dashboard view
    renderDashboard($user, $latestOrder, $userPermissions, $activePage, $canViewProduct, $canManageUser);
}
?>