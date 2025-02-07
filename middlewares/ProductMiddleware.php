<?php

function validateProduct($name, $price, $photo, $is_update = false) {
    if ($name == '') {
        $_SESSION['product_errors']['name'] = "Product name is required.";
    }

    if (($price == '') || !is_numeric($price) || $price <= 0) {
        $_SESSION['product_errors']['price'] = "Invalid price.";
    }

    // Validate photo only if it's not an update or if a new photo is uploaded
    if (!$is_update || !empty($photo['name'])) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!empty($photo['name']) && !in_array($photo['type'], $allowed_types)) {
            $_SESSION['product_errors']['photo'] = "Only JPG and PNG files are allowed.";
        }
        if (!empty($photo['size']) && $photo['size'] > 2 * 1024 * 1024) {
            $_SESSION['product_errors']['photo'] = "File size must be less than 2MB.";
        }
        if (empty($photo['name'])) {
            $_SESSION['product_errors']['photo'] = "Product photo is required.";
        }
    }
}

function productFeedback() {
    $formFeedback = '';
    if (isset($_SESSION['product_errors'])) {
        $formFeedback = $_SESSION['product_errors'];
        unset($_SESSION['product_errors']);
    }
    return $formFeedback;
}

function validateProductMW(){

    $categories = getAllCategories();
    $activePage = 'product-management';

    $product['name'] = htmlspecialchars($_POST['name']);
    $product['price'] = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $checkedCategories = $_POST['category'] ?? [];


    validateProduct($product['name'], $product['price'], $photo);
    $formFeedback = productFeedback();
    if (!empty($formFeedback)) {
        renderView('product/add_product_view',['categories'=>$categories,
            'activePage'=>$activePage,
            'product'=>$product,
            'formFeedback'=>$formFeedback,
            'checkedCategories'=>$checkedCategories]);
        exit;
    }

}

function getProductIdFromUrl() {
    // Access the current URL
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Use regular expression to capture the product ID from the URL path (e.g., /edit-product/12 or /delete-product/12)
    preg_match('/^\/(edit-product|delete-product)\/(\d+)$/', $requestUri, $matches);

    // Check if product ID is captured and return it
    if (isset($matches[2])) {
        return $matches[2];
    }

    // Return null if product ID is not found
    return null;
}



function editProductMW()
{

    // Extract product_id from the URL
    $product_id = getProductIdFromUrl();


    // Fetch the product details using the extracted product_id
    $product = fetchAllProductDetails($product_id);

    if (!$product) {
        die("Product not found.");
    }
}

function deleteProductMW()
{
    // Extract product_id from the URL
    $product_id = getProductIdFromUrl();


    // Fetch the product details using the extracted product_id
    $product = getProductById($product_id);

    if (!$product) {
        die("Product not found.");
    }
}

function validateEditProductMW(){


    // Extract product_id from the URL
    $product_id = getProductIdFromUrl();


    $product = fetchAllProductDetails($product_id);
    $categories = getAllCategories();
    $activePage = 'product-management';

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];
    $categoryIds = $_POST['category'] ?? [];

    validateProduct($name, $price, $photo, $is_update = true);

    $formFeedback = productFeedback();

    if(!empty($formFeedback)){
        renderView('product/edit_product_view', ['formFeedback' => $formFeedback,
            'categories'=>$categories,
            'product'=>$product,
            'activePage'=>$activePage]);
        exit;
    }


}
