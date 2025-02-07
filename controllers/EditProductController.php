<?php

function showEditProductPage($product_id){

    $product = fetchAllProductDetails($product_id);
    $categories = getAllCategories();
    $activePage = 'product-management';
    $activeForm = 'get-edit-product';

    renderView('product/edit_product_view',['product'=>$product,
        'categories'=>$categories,
        'activePage'=>$activePage,
        'activeForm'=>$activeForm]);

}

function submitEditProductForm($product_id)
{

    $product['name'] = htmlspecialchars($_POST['name']);
    $product['price'] = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $checkedCategories = $_POST['category'] ?? [];

    updateProduct($product['name'], $product['price'], $photo, $product_id, $checkedCategories);

}
