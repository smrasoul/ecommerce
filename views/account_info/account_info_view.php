
<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php if (isset($flash_message['edit_user_success'])) : ?>
            <div class="alert alert-success col-4 text-center">
                <p class="mb-0"> <?= $flash_message['edit_user_success'] ?></p>
            </div>
        <?php endif; ?>

        <?php require 'views/account_info/account_form.php' ?>

    </div>
</div>