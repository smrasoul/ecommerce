<?php

require 'models/HomeModel.php';

function showHomePage($products)
{
    renderView('home_view', [
        'products' => $products
    ]);
}
