<?php

require 'models/ProductModel.php';


// Show a particular product page
function showProductPage($product_id)
{
    $product = showProduct($product_id);
    $categories = getAllCategories();

    renderView('/product/product_view', ['product' => $product, 'categories' => $categories]);
}





// Product management page
function showProductManagement()
{

    $activePage = 'product';
    $products = showProduct();

    renderView('product/product_management_view', ['activePage' => $activePage,
        'products' => $products]);

}





// Create Product
function showCreateProduct()
{

    $categories = getAllCategories();
    $activePage = 'product';

    renderView('product/add_product_view', ['categories' => $categories,
        'activePage' => $activePage,]);

}

function submitCreateProduct()
{

    $activePage = 'product';
    $categories = getAllCategories();
    $product['name'] = htmlspecialchars($_POST['name']);
    $product['price'] = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $checkedCategories = $_POST['category'] ?? [];

    $photo_name = uploadPhotoToStorage($photo);
    $product_id = createProduct($product['name'], $product['price']);
    $media = createProductImage($product_id, $photo_name);
    $categories = addProductCategories($product_id, $checkedCategories);

    setFlashMessage(['photo' => $photo_name,
        'product' => $product_id,
        'media' => $media,
        'categories' => $categories]);

    redirect('/admin/product');

}




// Update Product
function showUpdateProduct($product_id)
{

    $product = showProduct($product_id);
    $categories = getAllCategories();
    $activePage = 'product';

    renderView('product/edit_product_view', ['product' => $product,
        'categories' => $categories,
        'activePage' => $activePage,]);

}

function submitUpdateProduct($product_id)
{

    $product['name'] = htmlspecialchars($_POST['name']);
    $product['price'] = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $checkedCategories = $_POST['category'] ?? [];

    if (!empty($photo['name'])) {

        $storageDelete = deletePhotoFromStorage($product_id);
        $mediaDelete = deleteMedia($product_id);
        $photo_name = uploadPhotoToStorage($photo);
        $media = createProductImage($product_id, $photo_name);

        setFlashMessage(['photo_delete' => $storageDelete,
            'media_delete' => $mediaDelete,
            'photo' => $photo_name,
            'media' => $media,]);
    }

    $categoriesDelete = deleteProductCategories($product_id);
    $categories = addProductCategories($product_id, $checkedCategories);

    $productUpdate = updateProduct($product['name'], $product['price'], $product_id);

    setFlashMessage(['product_update' => $productUpdate,
        'categories_delete' => $categoriesDelete,
        'categories' => $categories]);

    redirect('/admin/product');
}





// Delete Product
function deleteProduct($product_id)
{
    $product = getProductById($product_id);

    $storageDelete = deletePhotoFromStorage($product_id);
    $mediaDelete = deleteMedia($product_id);

    $categoriesDelete = deleteProductCategories($product_id);

    $productDelete = deleteProductById($product_id);

    setFlashMessage(['storage_delete' => $storageDelete,
        'media_delete' => $mediaDelete,
        'categories_delete' => $categoriesDelete,
        'product_delete' => $productDelete]);

    redirect('/admin/product');
}
