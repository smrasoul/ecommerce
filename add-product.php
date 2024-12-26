<?php

require 'includes/init.php';


$userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
var_dump($userPermissions);


if (!hasPermission('add_product', $userPermissions)) {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];

    // Validation
    validateProduct($name, $price, $photo);

    $formFeedback = productFeedback();
    var_dump($formFeedback);


    // If no errors, save the product
    if (empty($formFeedback)) {

        $photo_name = time() . '_' . basename($photo['name']);
        $upload_path = 'assets/images/' . $photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path))
        {
            addProduct($name, $price, $photo_name, $conn);
        } else {
            $_SESSION['product_errors']['photo'] = "Failed to upload photo.";
        }
    }
}
mysqli_close($conn);

?>

<?php require 'includes/header.php' ?>

    <h1>Add Product</h1>

    <?php require 'includes/product-form.php'; ?>

<?php require 'includes/footer.php' ?>

