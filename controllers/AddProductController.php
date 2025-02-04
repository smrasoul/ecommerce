<?php

function showAddProductPage(){
    $categories = getAllCategories();
    $activePage= 'product-management';

    renderView('product/add_product_view', ['categories' => $categories,
        'activePage' => $activePage]);

}

function submitAddProductForm(){

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $categoryIds = $_POST['category'] ?? [];

    $photo_name = uploadProductPhoto($photo);
    $product_id = addProduct($name, $price, $photo_name);
    addProductCategories($product_id, $categoryIds);


}
