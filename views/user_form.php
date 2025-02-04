<?php

$user['first_name'] = $user['first_name'] ?? '';
$user['last_name'] = $user['last_name'] ?? '';
$user['email'] = $user['email'] ?? '';
$user['username'] = $user['username'] ?? '';

?>


<form method="POST" novalidate>

    <div class="row mb-4">
        <div class="row col-6">
            <label for="firstName" class="col-4 fw-bold">First Name</label>
            <div class="col-8">
                <input type="text"
                       class="form-control <?= isset($formFeedback['firstName']) ? 'is-invalid' : '' ?>"
                       id="firstName" name="firstName" value="<?= $user['first_name'] ?>">
                <?php if (isset($formFeedback['firstName'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['firstName'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row col-6">
            <label for="lastName" class="col-4 fw-bold">Last Name</label>
            <div class="col-8">
                <input type="text"
                       class="form-control <?= isset($formFeedback['lastName']) ? 'is-invalid' : '' ?>"
                       id="lastName" name="lastName" value="<?= $user['last_name'] ?>">
                <?php if (isset($formFeedback['lastName'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['lastName'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="row col-6">
            <label for="email" class="col-4 fw-bold">Email</label>
            <div class="col-8">
                <input type="email"
                       class="form-control <?= isset($formFeedback['email']) ? 'is-invalid' : '' ?>"
                       id="email" name="email" value="<?= $user['email'] ?>">
                <?php if (isset($formFeedback['email'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['email'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row col-6">
            <label for="username" class="col-4 fw-bold">Username</label>
            <div class="col-8">
                <input type="text"
                       class="form-control <?= isset($formFeedback['username']) ? 'is-invalid' : '' ?>"
                       id="username" name="username" value="<?= $user['username'] ?>">
                <?php if (isset($formFeedback['username'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['username'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($activeForm == 'Signup'): ?>
        <div class="row mb-4">
            <div class="row col-6">
                <label for="password" class="col-4 fw-bold">Password</label>
                <div class="col-8">
                    <input type="password"
                           class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                           id="password" name="password">
                    <?php if (isset($formFeedback['password'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row col-6">
                <label for="retypePassword" class="col-4 fw-bold">Retype Password</label>
                <div class="col-8">
                    <input type="password"
                           class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                           id="retypePassword" name="retypePassword">
                    <?php if (isset($formFeedback['password'])) : ?>
                        <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-end">
        <?php if(isset($_SESSION['is_logged_in'])): ?>
        <a class="link-light link-underline-opacity-0 btn btn-danger" href="account-info">Cancel</a>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary ms-4"><?= isset($_SESSION['is_logged_in']) ? 'Save' : 'Sign Up' ?></button>
    </div>
</form>