<form method="POST" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label for="name">Product Name</label>
        <div class="col-5">
            <input type="text"
                   class="form-control <?= isset($formFeedback['name']) ? 'is-invalid' : '' ?>"
                   id="name" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>">
            <?php if (isset($formFeedback['name'])) : ?>
                <div class="invalid-feedback"><?= $formFeedback['name'] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="price">Price</label>
        <div class="col-5">
            <input type="text"
                   class="form-control <?= isset($formFeedback['price']) ? 'is-invalid' : '' ?>"
                   id="price" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>">
            <?php if (isset($formFeedback['price'])) : ?>
                <div class="invalid-feedback"><?= $formFeedback['price'] ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="photo">Product Photo</label>
        <div class="col-5 mb-2">
            <input type="file"
                   class="form-control <?= isset($formFeedback['photo']) ? 'is-invalid' : '' ?>"
                   id="photo" name="photo" value="<?= htmlspecialchars($product['photo'] ?? '') ?>">
            <?php if (isset($formFeedback['photo'])) : ?>
                <div class="invalid-feedback"><?= $formFeedback['photo'] ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($productPhoto)): ?>
            <p>Current Photo: <img src="assets/media/<?= htmlspecialchars($productPhoto[0]['file_path']) ?>" alt="Product Photo" width="50"></p>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success"><?= isset($product) ? 'Update Product' : 'Add Product' ?></button>
</form>
