<form method="POST" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label for="name">Product Name</label>
        <div class="col-4">
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="price">Price</label>
        <div class="col-4">
        <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="photo">Product Photo</label>
        <div class="col-4 mb-2">
        <input type="file" class="form-control" id="photo" name="photo" <?= isset($product) ? '' : 'required' ?>>
        </div>
        <?php if (!empty($product['photo'])): ?>
            <p>Current Photo: <img src="../assets/images/<?= htmlspecialchars($product['photo']) ?>" alt="Product Photo" width="50"></p>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update Product' : 'Add Product' ?></button>
</form>
