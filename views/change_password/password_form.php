<form method="POST">
        <div class="row mb-4 ms-5">
            <label for="current_password" class=" fw-bold">Current Password</label>
            <div class="col-6">
                <input type="password"
                       class="form-control <?= isset($formFeedback['current_password']) ? 'is-invalid' : '' ?>"
                       id="current_password" name="current_password">
                <?php if (isset($formFeedback['current_password'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['current_password'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-4 ms-5">
            <label for="new_password" class=" fw-bold">New Password</label>
            <div class="col-6">
                <input type="password"
                       class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                       id="new_password" name="new_password">
                <?php if (isset($formFeedback['password'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-4 ms-5">
            <label for="confirm_password" class=" fw-bold">Confirm New Password</label>
            <div class="col-6">
                <input type="password"
                       class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                       id="confirm_password" name="confirm_password">
                <?php if (isset($formFeedback['password'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-flex justify-content-center">

            <a class="link-dark link-underline-opacity-0 btn btn-outline-danger" href="account-info">Cancel</a>

            <button type="submit" class="btn btn-success ms-4">Change Password</button>
        </div>
</form>