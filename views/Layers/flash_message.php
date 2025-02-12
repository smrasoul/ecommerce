<?php if (isset($_SESSION['flash_success'])) : ?>
    <div class="alert alert-success col-4 text-center">
        <?= $_SESSION['flash_success'] ?>
    </div>
    <?php unset($_SESSION['flash_success']) ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash_danger'])) : ?>
    <div class="alert alert-danger col-4 text-center">
        <?= $_SESSION['flash_danger'] ?>
    </div>
    <?php unset($_SESSION['flash_danger']) ?>
<?php endif; ?>
