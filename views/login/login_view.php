<?php

$username = $username ?? '';

?>

    <h1 class="my-4">Login</h1>
    <div class="">
        <?php if (isset($flash_message['signup_success'])) : ?>
            <div class="alert alert-success col-4 text-center">
                <p class="mb-0"><?= $flash_message['signup_success'] ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($flash_message['auth_error'])) : ?>
            <div class="alert alert-danger col-4 text-center">
                <p class="mb-0"><?= $flash_message['auth_error'] ?></p>
            </div>
        <?php endif; ?>

        <?php require 'login_form.php'; ?>
    </div>
<?php

