<?php



function showChangePasswordPage(){

    $activePage = 'account-info';
    renderView('change_password/change_password_view',['activePage' => $activePage]);
}

function submitChangePasswordForm(){

    $userId = $_SESSION['user_id'];
    $newPassword = $_POST['new_password'];
    updatePassword($newPassword, $userId );
}
