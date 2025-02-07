<?php

function showAddProductPage(){

    $categories = getAllCategories();
    $activePage= 'product-management';

    renderView('product/add_product_view',['categories'=>$categories,
        'activePage'=>$activePage,]);

}

function submitAddProductForm(){

    $product['name'] = htmlspecialchars($_POST['name']);
    $product['price'] = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $checkedCategories = $_POST['category'] ?? [];

    $photo_name = uploadProductPhoto($photo);
    $product_id = addProduct($product['name'], $product['price'], $photo_name);
    $success = addProductCategories($product_id, $checkedCategories);
    if($success){
        redirect('/product-management');
    }
}
