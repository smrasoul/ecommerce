<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';

$userPermissions = checkUserAccess($conn);

$user_id = $_SESSION['user_id'];
//var_dump($user_id);

$user = getUserinfo($conn, $user_id);
//var_dump($user);

$activePage = 'account-info';


$flash_message = '';
if (isset($_SESSION['flash'])) {
    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);
}



?>

<?php require 'includes/View/Layers/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php if (isset($flash_message['edit_user_success'])) : ?>
            <div class="alert alert-success col-4 text-center">
                <p class="mb-0"> <?= $flash_message['edit_user_success'] ?></p>
            </div>
        <?php endif; ?>

        <?php require 'src/Account-info/View/account-form.php' ?>

    </div>
</div>

<?php require 'includes/View/Layers/footer.php' ?>
