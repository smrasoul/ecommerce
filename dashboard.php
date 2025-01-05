<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';
require 'src/Order/Function/order-functions.php';


$userPermissions = checkUserAccess($conn);

$activePage = 'dashboard';

$user_id = $_SESSION['user_id'];
//var_dump($user_id);

$user = getUserinfo($conn, $user_id);
//var_dump($user);

$latestOrder = getLatestOrder($conn, $user_id);
//var_dump($latestOrder);

?>

<?php require 'includes/View/Layers/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">

        <?php require 'includes/View/Layers/sidebar.php' ?>

    </div>
    <div class="col-9 border rounded p-4">

        <?php require 'src/Dashboard/View/dashboard-summary.php' ?>

    </div>
</div>

<?php require 'includes/View/Layers/footer.php' ?>
