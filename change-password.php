<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';
require 'src/User/Validation/user-validation.php';

$userPermissions = checkUserAccess($conn);

$user_id = $_SESSION['user_id'];
//var_dump($user_id);

$activePage = 'account-info';

$currentPassword = '';
$newPassword = '';
$confirmPassword = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    validatePasswordForm($currentPassword, $newPassword);
    passwordsMatch($newPassword, $confirmPassword);
    validatePasswords($currentPassword, $newPassword, $user_id, $conn);

    $formFeedback = userFeedback();

    if(empty($formFeedback)) {
        updatePassword($conn, $newPassword, $user_id );
    }

}

?>

<?php require 'includes/View/Layers/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php if (isset($_SESSION['password_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['password_failure'] ?>
            </div>
            <?php unset($_SESSION['password_failure']) ?>
        <?php endif; ?>

        <?php require 'src/User/View/password-form.php'; ?>

    </div>

</div>

<?php require 'includes/View/Layers/footer.php'; ?>
