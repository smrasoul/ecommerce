<?php if (isset($_SESSION['success_message'])): ?>
    <div class="row justify-content-center">
        <div class="alert alert-success col-4 d-flex">
            <?= $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="row  justify-content-center">

        <div class="alert alert-danger col-4 d-flex"><?= $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
        </div>
    </div>
<?php endif; ?>