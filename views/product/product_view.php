<article class="product-details my-4 border rounded p-4 shadow-sm">
    <h2 class="product-title text-primary"><?= htmlspecialchars($product['name']) ?></h2>

    <div class="my-4">
        <img class="rounded img-fluid" src="/assets/media/<?= htmlspecialchars($product['main_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 300px;">
    </div>

    <p class="price text-success h4">Price: $<?= htmlspecialchars($product['price']) ?></p>

    <h3 class="categories-title h5">Categories:</h3>
    <ul class="list-inline">
        <?php foreach ($product['categories'] as $category): ?>
            <li class="p-2 list-inline-item badge bg-secondary"><?= htmlspecialchars($category) ?></li>
        <?php endforeach; ?>
    </ul>

    <button class="btn btn-primary btn-lg">Add to Cart</button>
</article>
