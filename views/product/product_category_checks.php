<?php if(isset($checkedCategories) && in_array($category['id'], $checkedCategories)):?>
    checked
<?php elseif($activeForm = 'get-edit-product' && isset($product["categories"]) && in_array($category['name'], $product["categories"])): ?>
    checked
<?php endif; ?>