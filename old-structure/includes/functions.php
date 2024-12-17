<?php

function getAllProducts($conn){

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    return $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
}