<?php

function showEditProductPage($product_id){

    $product = fetchAllProductDetails($product_id);
    $categories = getAllCategories();
    $activePage = 'product-management';

    renderView('product/edit_product_view',['product'=>$product,
        'categories'=>$categories,
        'activePage'=>$activePage]);

}

function submitEditProductForm($product_id)
{

    $categories = getAllCategories();
    $activePage = 'product-management';

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $categoryIds = $_POST['category'] ?? [];

    updateProduct($name, $price, $photo, $product_id, $categoryIds);

}
