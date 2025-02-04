<?php

require 'models/ProductModel.php';

function showProductManagementPage(){

    $activePage= 'product-management';
    $products = fetchAllProductDetails();

    $flash_message = '';

    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    renderView('product/product_management_view', ['activePage'=>$activePage,
        'products' => $products,
        'flash_message' => $flash_message]);

}
