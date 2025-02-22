<?php

function getOrders($userId, $conn) {
    $query = "SELECT * FROM `orders` WHERE `user_id` = ? ORDER BY `id` DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getLatestOrder($conn, $userId) {
    $query = "SELECT * FROM `orders` WHERE `user_id` = ? ORDER BY `id` LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $latestOrder = mysqli_fetch_assoc($result);
}
