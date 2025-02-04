<?php

require 'includes/init.php';
require 'src/Order/Function/order-functions.php';

$userPermissions = checkUserAccess($conn);

$userId = $_SESSION['user_id'];
$orders = getOrders($userId, $conn);
//var_dump($orders);

$activePage = 'orders';

?>

<?php require 'includes/View/Layers/header.php' ?>



<?php require 'includes/View/Layers/footer.php' ?>
