<?php

require 'includes/init.php';

// Ensure the user has permission to edit products
if (!has_permission('edit_product')) {
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit;
}

$conn = get_db_connection();

// Check if the product ID is provided
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];

// Fetch product details
$product = get_by_id($conn, $product_id);
if (!$product) {
    die("Product not found.");
}

// Initialize errors array
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $photo = $_FILES['photo'];

    // Validate input fields
    $errors = validate_product($name, $price, $photo, true);

    if (empty($errors)) {

            if(! $photo_name = handle_photo($product, $photo)) {
                $errors[] = "Failed to upload the new photo.";
            }
        // Update the product in the database
        if (empty($errors)) {

            if(! update_product ($conn, $name, $price, $photo_name, $product_id )){
                $errors[] = "Failed to update the product.";
            }
        }
    }

    if(empty($errors)) {
        redirect('/admin/dashboard.php');
    }
}

mysqli_close($conn);

?>

<?php require dirname(__DIR__) . '/includes/header.php'; ?>

<h1>Edit Product</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Shared product form -->
<form method="POST" enctype="multipart/form-data">
    <?php require 'includes/product-form.php'; ?>
</form>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
