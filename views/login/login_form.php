<?php
// Ensure $username is defined
$username = $username ?? '';
?>

<form method="POST" novalidate>
        <div class="form-group mb-2 row">
            <label for="username">Username</label>
            <div class="col-4">
                <input type="text" class="form-control <?= isset($formFeedback['username_error']) ? 'is-invalid' : '' ?>"
                       id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                <?php if (isset($formFeedback['username_error'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['username_error'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group mb-2 row">
            <label for="password">Password</label>
            <div class="col-4">
                <input type="password" class="form-control <?= isset($formFeedback['password_error']) ? 'is-invalid' : '' ?>"
                       id="password" name="password"
                >
                <?php if (isset($formFeedback['password_error'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password_error'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
