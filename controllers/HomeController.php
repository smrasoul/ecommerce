<?php

require 'models/HomeModel.php';

function showHomePage()
{
    $products = fetchAllProducts();

    renderView('home_view', [
        'products' => $products
    ]);
}
