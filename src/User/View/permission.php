<div class="col-6">
    <h4>Assign Permissions to Role</h4>

    <form method="GET" action="manage-user.php">
        <div class="mb-3 col">
            <label for="role_id" class="form-label">Select a Role:</label>
            <select class="form-select mb-3" id="role_id" name="role_id" required>
                <?php foreach ($roles as $role): ?>
                    <option
                        <?php if ($role['id'] == 1): ?>
                            disabled
                        <?php endif; ?>
                        <?php if(isset($_GET['role_id']) && is_numeric($_GET['role_id']) && $role['id'] == $_GET['role_id']): ?>
                            selected
                        <?php endif; ?>
                            value="<?= $role['id']; ?>"><?= $role['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-success">Check Permissions</button>
    </form>
    <?php if(isset($getRoleCheck) && $getRoleCheck): ?>
        <form method="POST" class="my-4">
            <div class="mb-3">
                <label class="form-label">Select Permissions</label>
                <?php foreach ($permissions as $permission) : ?>
                    <div class="form-check">
                        <input type="checkbox" name="permission[]" value="<?= $permission['id'] ?>" id="permission<?= $permission['id'] ?>" class="form-check-input"
                            <?php if (isset($rolePermissions[$getRoleID]) && in_array($permission['id'], $rolePermissions[$getRoleID])): ?>
                                checked
                            <?php endif; ?>
                        >
                        <label for="permission<?= $permission['id'] ?>" class="form-check-label"><?= htmlspecialchars($permission['name']) ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" name="assign_permissions" class="btn btn-primary">Assign Permissions</button>
        </form>
    <?php endif; ?>
</div>