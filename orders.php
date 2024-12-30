<?php

require 'includes/init.php';
require 'src/Order/Function/order-functions.php';

$userPermissions = checkUserAccess($conn);

$userId = $_SESSION['user_id'];
$orders = getOrders($userId, $conn);
//var_dump($orders);

$activePage = 'orders';

?>

<?php require 'includes/View/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
    </div>
    <div class="col-9 border rounded py-3">
       <?php require 'src/Order/View/order-table.php' ?>
    </div>
</div>

<?php require 'includes/View/footer.php' ?>
