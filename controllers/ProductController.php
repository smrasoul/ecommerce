<?php

require 'models/ProductModel.php';
require 'views/Product_view.php';

function showProductListPage($conn, $product_id = null)
{
    $products = fetchAllProductDetails($conn, $product_id);
    renderProductListPage($products);
}
