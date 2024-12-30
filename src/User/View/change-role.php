<div class="col-6">
    <h3>Change User Role</h3>
    <form method="POST">
        <div class="mb-3">


            <label for="user_id" class="form-label">Select User: (Current Role)</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <?php foreach ($users_roles as $user_role): ?>
                    <option value="<?= $user_role['id'] ?>"
                        <?php if ($user_role['username'] == 'admin'): ?>
                            disabled
                        <?php endif; ?>
                    >
                        <?= $user_role['username'] . ": (" . $user_role['role_name'] . ")" ?>

                    </option>
                <?php endforeach; ?>
            </select>


        </div>
        <div class="mb-3">
            <label for="new_role_id" class="form-label">Select New Role</label>
            <select class="form-select" id="new_role_id" name="new_role_id" required>

                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id']; ?>"><?= $role['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="change_user_role" class="btn btn-primary">Change Role</button>
    </form>
</div>