<?php

require 'includes/init.php';

if (!hasPermission('add_product')) {
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
    $errors = validateProduct($name, $price, $photo);

    // If no errors, save the product
    if (empty($errors)) {

        $photo_name = time() . '_' . basename($photo['name']);
        $upload_path = '../assets/images/' . $photo_name;

        if (move_uploaded_file($photo['tmp_name'], $upload_path))
        {
            addProduct($name, $price, $photo_name, $conn);
        } else {
            $errors[] = "Failed to upload photo.";
        }
    }
}
mysqli_close($conn);

?>

<?php require dirname(__DIR__) . '/includes/header.php' ?>

    <h1>Add Product</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php require 'includes/product-form.php'; ?>

<?php require dirname(__DIR__) . '/includes/footer.php' ?>

