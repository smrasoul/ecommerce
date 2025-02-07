<?php

function showProductPage($product_id)
{
    $product = fetchAllProductDetails($product_id);
    $categories = getAllCategories();

    renderView('/product/product_view', ['product' => $product, 'categories' => $categories]);
}
