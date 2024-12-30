<?php if (isset($flash_message['product_success'])) : ?>
    <div class="alert alert-success col-4 text-center">
        <p class="mb-0"> <?= $flash_message['product_success'] ?></p>
    </div>
<?php endif; ?>

<?php if (isset($flash_message['delete_failure'])) : ?>
    <div class="alert alert-danger col-4 text-center">
        <p class="mb-0"> <?= $flash_message['delete_failure'] ?></p>
    </div>
<?php endif; ?>

<?php if (isset($flash_message['delete_success'])) : ?>
    <div class="alert alert-success col-4 text-center">
        <p class="mb-0"> <?= $flash_message['delete_success'] ?></p>
    </div>
<?php endif; ?>