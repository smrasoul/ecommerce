<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php if (isset($_SESSION['edit_user_failed'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['edit_user_failed'] ?>
            </div>
            <?php unset($_SESSION['edit_user_failed']) ?>
        <?php endif; ?>

        <?php require 'views/user_form.php'; ?>

    </div>

</div>
