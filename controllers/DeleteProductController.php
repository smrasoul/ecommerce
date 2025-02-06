<?php

function deleteProduct($product_id)
{
    $product = getProductById($product_id);

    if ($product) {
        if (!deleteProductCategories($product_id)) {
            $_SESSION['flash']['product_failure'] = 'Failed to delete the product.';
        } elseif (!deleteProductImage($product_id)) {
            $_SESSION['flash']['product_failure'] = 'Failed to delete the product.';
        } elseif(deleteProductById($product_id)) {
            $_SESSION['flash']['product_success'] = 'The product was successfully deleted.';
            redirect('/product-management');
        }
    }

}
