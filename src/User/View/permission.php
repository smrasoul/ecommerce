<div class="col-6">
    <h4>Assign Permissions to Role</h4>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="role_id" class="form-label">Select Role</label>
            <select class="form-select" id="role_id" name="role_id" required>
                <?php foreach ($roles as $role): ?>
                    <option
                        <?php if ($role['id'] == 1): ?>
                            disabled
                        <?php endif; ?>
                        value="<?= $role['id']; ?>"><?= $role['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Permissions</label>
            <?php foreach ($permissions as $permission): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]"
                           value="<?= $permission['id']; ?>" id="permission_<?= $permission['id']; ?>">
                    <label class="form-check-label" for="permission_<?= $permission['id']; ?>">
                        <?= $permission['name']; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" name="assign_permissions" class="btn btn-primary">Assign Permissions</button>
    </form>
</div>
