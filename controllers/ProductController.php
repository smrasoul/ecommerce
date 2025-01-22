<?php

require 'models/ProductModel.php';
require 'views/Product_view.php';

function showProducts($conn, $product_id = null)
{
    $products = fetchAllProductDetails($conn, $product_id);
    renderProducts($products);
}
