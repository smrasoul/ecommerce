<h1 class="my-4">Admin Dashboard</h1>

<?php require 'views/user_management/manage_flash.php'; ?>

<div class="row">

    <div class="col-3">
        <?php require 'views/Layers/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded py-3">
        <div class="row">
            <?php require 'views/user_management/create_role.php' ?>
            <?php require 'views/user_management/permission.php' ?>
        </div>
        <div class="row">
            <?php require 'views/user_management/change_role.php' ?>
        </div>
    </div>

</div>