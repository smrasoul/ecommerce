<?php

function showOrdersHistory(){

    $user_Id = $_SESSION['user_id'];
    $orders = getOrders($user_Id);
    $activePage = 'orders-history';

    renderView('orders_history/orders_history_view', ['orders' => $orders,
        'activePage' => $activePage]);
}
