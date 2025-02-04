<div class="col-6">
    <h4>Assign Role to User</h4>

    <form method="POST">
        <div class="mb-3 col">
            <label for="user_id" class="form-label">Select a User:</label>
            <select class="form-select mb-3" id="user_id" name="user_id" required>
                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                    <option value="<?= $user['id']; ?>" data-role-id="<?= $user['role_id']; ?>"><?= htmlspecialchars($user['username']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Role</label>
            <?php foreach ($roles as $role): ?>
                <div class="form-check">
                    <input type="radio" name="role_id" value="<?= $role['id']; ?>" id="role<?= $role['id']; ?>" class="form-check-input">
                    <label for="role<?= $role['id']; ?>" class="form-check-label"><?= htmlspecialchars($role['name']); ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" name="assign_role" class="btn btn-primary">Assign Role</button>
    </form>
</div>
