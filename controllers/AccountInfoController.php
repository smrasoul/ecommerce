<?php

require_once 'models/UserModel.php';


function showAccountInfoPage() {

    $activePage = 'account-info';
    $user_id = $_SESSION['user_id'];
    $user = getUserInfo($user_id);

    renderView('account_info/account_info_view', ['activePage' => $activePage,
        'canViewProduct' => $GLOBALS['canViewProduct'],
        'canManageUser' => $GLOBALS['canManageUser'],
        'user' => $user]);

}
