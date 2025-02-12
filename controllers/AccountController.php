<?php

require_once 'models/UserModel.php';


function showAccountInfo() {

    $activePage = 'account-info';
    $user_id = $_SESSION['user_id'];
    $user = getUserInfo($user_id);

    renderView('account_info/account_info_view', ['activePage' => $activePage,
        'canManageProduct' => $GLOBALS['canManageProduct'],
        'canManageUser' => $GLOBALS['canManageUser'],
        'user' => $user]);

}




//Editing account information
function showEditAccount()
{

    $activePage = 'account-info';
    $activeForm = 'account-info';

    $user_id = $_SESSION['user_id'];
    $user = getUserinfo($user_id);

    renderView('edit_account_view', ['user' => $user,
        'activePage' => $activePage,
        'activeForm' => $activeForm]);
}

function submitEditAccount()
{

    $user_id = $_SESSION['user_id'];

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);

    $userResult = updateUser($user['first_name'], $user['last_name'], $user['email'], $user['username'], $user_id);

    setFlashMessage(['user' => $userResult] );

    redirect('/user/account');

}



//Password
function showChangePassword()
{

    $activePage = 'account-info';
    renderView('change_password/change_password_view', ['activePage' => $activePage]);
}

function submitChangePassword()
{

    $userId = $_SESSION['user_id'];
    $newPassword = $_POST['new_password'];
    $password = hashPassword($newPassword);
    $passwordResult = updatePassword($password, $userId);
    setFlashMessage(['password' => $passwordResult] );
    redirect('/user/account');
}

