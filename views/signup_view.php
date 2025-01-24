<?php

function renderSignupPage($user, $activeForm, $formFeedback)
{
    require 'views/Layers/header.php';

    ?>

    <h1 class="my-4">Sign Up</h1>

    <div class="border rounded p-4">

        <?php if (isset($_SESSION['signup_failure'])) : ?>
            <div class="alert alert-danger">
                <?= $_SESSION['signup_failure'] ?>
            </div>
            <?php unset($_SESSION['signup_failure']) ?>
        <?php endif; ?>

        <?php require 'views/user_form.php'; ?>

    </div>

    <?php require 'views/Layers/footer.php';
}

?>