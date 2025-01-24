<?php

require_once 'models/UserModel.php';
require_once 'views/account_info/account_info_view.php';

function showAccountInfoPage($conn) {

    $userPermissions = checkUserAccess($conn);

// Check permissions for sidebar links
    $canViewProduct = hasPermission('view_product', $userPermissions);
    $canManageUser = hasPermission('manage_user', $userPermissions);

    $user_id = $_SESSION['user_id'];

    $user = getUserinfo($conn, $user_id);


    $activePage = 'account-info';


    $flash_message = '';
    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    renderAccountInfoPage($user, $activePage, $canViewProduct, $canManageUser);
}
