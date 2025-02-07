

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
                   id="photo" name="photo">
            <?php if (isset($formFeedback['photo'])) : ?>
                <div class="invalid-feedback"><?= $formFeedback['photo'] ?></div>
            <?php endif; ?>
        </div>
        <?php if (isset($product['main_image'])): ?>
            Current Photo:
            <img src="/assets/media/<?= htmlspecialchars($product['main_image']) ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>" width="50">
        <?php endif; ?>
    </div>
    <fieldset class="mb-3">
        <legend>Categories</legend>

        <?php foreach ($categories as $category) : ?>
            <div class="form-check">
                <input type="checkbox" name="category[]" value="<?= $category['id'] ?>" id="category<?= $category['id'] ?>" class="form-check-input"
                    <?php if(isset($checkedCategories) && in_array($category['id'], $checkedCategories)):?>
                        checked
                    <?php endif; ?>
                >
                <label for="category<?= $category['id'] ?>" class="form-check-label"><?= htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>


    </fieldset>
    <button type="submit" class="btn btn-primary"><?= ($activeForm = 'update-product') ? 'Update Product' : 'Add Product'?></button>
</form>
