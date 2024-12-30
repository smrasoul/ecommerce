<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';

$userPermissions = checkUserAccess($conn);

$user_id = $_SESSION['user_id'];
//var_dump($user_id);

$user = getUserinfo($conn, $user_id);
//var_dump($user);

$activePage = 'account-info';



?>

<?php require 'includes/View/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php require 'src/Account-info/View/account-form.php' ?>

    </div>
</div>

<?php require 'includes/View/footer.php' ?>
