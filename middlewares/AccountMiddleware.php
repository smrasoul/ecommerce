<?php


//Editing account information middleware
function validateEditAccountMW()
{

    $user_id = $_SESSION['user_id'];
    $user = getUserinfo($user_id);

    $originalUsername = $user['username'];
    $originalEmail = $user['email'];

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);


    validateUserForm($user['first_name'], $user['last_name'], $user['email'], $user['username']);
    if (!($originalEmail == $user['email'])) {
        checkEmailAvailability($user['email']);
    }
    if (!($originalUsername == $user['username'])) {
        checkUsernameAvailability($user['username']);
    }

    $formFeedback = userFeedback();

    if (!empty($formFeedback)) {
        $activePage = 'account-info';
        $activeForm = 'account-info';
        renderView('edit_account_view', ['formFeedback' => $formFeedback,
            'activePage' => $activePage,
            'activeForm' => $activeForm,
            'user' => $user]);
        exit;
    }
}





//Password middleware
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
