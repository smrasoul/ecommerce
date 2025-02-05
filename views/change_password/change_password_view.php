<h1 class="my-4">Dashboard</h1>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">

        <?php if (isset($_SESSION['password_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['password_failure'] ?>
            </div>
            <?php unset($_SESSION['password_failure']) ?>
        <?php endif; ?>

        <?php require 'views/change_password/password_form.php'; ?>

    </div>

</div>