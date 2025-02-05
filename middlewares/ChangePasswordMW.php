<?php

function validateChangePasswordMW()
{

    $user_id = $_SESSION['user_id'];

    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    validatePasswordForm($currentPassword, $newPassword);
    passwordsMatch($newPassword, $confirmPassword);
    validatePasswords($currentPassword, $newPassword, $user_id);

    $formFeedback = userFeedback();

    if (!empty($formFeedback)) {
        $activePage = 'account-info';
        renderView('change_password/change_password_view', ['formFeedback' => $formFeedback,
            'activePage' => $activePage]);
        exit;
    }
}
