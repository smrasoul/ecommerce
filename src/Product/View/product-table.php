<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Photo</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td class="align-content-center"><?= htmlspecialchars($product['id']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($product['name']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($product['price']) ?></td>
                <td class="align-content-center">
                    <ul class="card-text no-bullets">
                        <?php foreach ($product['categories'] as $category): ?>
                        <li>
                            <?= htmlspecialchars($category) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="align-content-center">
                    <?php if ($product['main_image']): ?>
                    <img src="/assets/media/<?= htmlspecialchars($product['main_image']) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>" width="50">
                    <?php else: ?>
                    <img src="/assets/images/default_product.png" class="card-img-top" alt="No photo" />
                    <?php endif; ?>
                </td>
                <td class="align-content-center">
                    <a href="edit-product.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete-product.php?id=<?= $product['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this product?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No products found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>