<?php



function showEditAccountPage(){

    $activePage = 'account-info';
    $activeForm = 'account-info';

    $user_id = $_SESSION['user_id'];
    $user = getUserinfo($user_id);

    renderView('edit_account_view', ['user' => $user,
        'activePage' => $activePage,
        'activeForm' => $activeForm]);
}

function submitEditAccountForm(){

    $user_id = $_SESSION['user_id'];

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);

    updateUserInfo($user['first_name'], $user['last_name'], $user['email'], $user['username'], $user_id);

}
