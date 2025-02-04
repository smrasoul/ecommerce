<?php

require 'models/HomeModel.php';

function showHomePage()
{
    $products = fetchAllProducts();
    var_dump($products);

    renderView('home_view', [
        'products' => $products
    ]);
}
