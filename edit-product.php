<?php

require 'includes/init.php';

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);

    if (!hasPermission('edit_product', $userPermissions)) {
        header('HTTP/1.1 403 Forbidden');
        echo "You do not have permission to access this page.";
        exit;
    }

} else {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = getDbConnection();


if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];


$product = getById($conn, $product_id);
if (!$product) {
    die("Product not found.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];

    // Validate input fields
    validateProduct($name, $price, $photo);

    if(! $photo_name = handlePhoto($product, $photo)) {
        $_SESSION['product_errors']['photo'] = "Failed to upload the new photo.";
    }

    $formFeedback = productFeedback();
    var_dump($formFeedback);

    // Update the product in the database
    if (empty($formFeedback)) {

        if (!updateProduct($conn, $name, $price, $photo_name, $product_id)) {
            $_SESSION['product_failure'] = "Failed to update the product.";
        }
    }


    if(empty($errors)) {
        redirect('/view-product.php');
    }
}

mysqli_close($conn);

?>

<?php require 'includes/header.php'; ?>

<h1>Edit Product</h1>

<?php if (isset($_SESSION['product_failure'])) : ?>
    <div class="alert alert-danger">
        <?= $_SESSION['product_failure'] ?>
    </div>
    <?php unset($_SESSION['product_failure']) ?>
<?php endif; ?>

<!-- Shared product form -->
<form method="POST" enctype="multipart/form-data">
    <?php require 'includes/product-form.php'; ?>
</form>

<?php require 'includes/footer.php'; ?>
