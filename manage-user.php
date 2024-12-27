<?php

session_start();
require 'includes/db.php';
require 'includes/auth.php';
require 'includes/user-functions.php';

$conn = getDbConnection();

$userPermissions = checkUserAccess($conn, 'manage_user');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['create_role'])) {
        $roleName = htmlspecialchars(trim($_POST['role_name']));
        $newRoleId = createRole($roleName, $conn);

        if ($newRoleId) {
            $_SESSION['success_message'] = "Role '$roleName' created successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to create role.";
        }
    }

    if (isset($_POST['assign_permissions'])) {
        $roleId = $_POST['role_id'];
        $permissionIds = $_POST['permissions'] ?? [];

        if(deleteRolePermissions($roleId, $conn)){
            if (assignPermissionsToRole($roleId, $permissionIds, $conn)) {
                $_SESSION['success_message'] = "Permissions assigned successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to assign permissions.";
            }
        } else {
            $_SESSION['error_message'] = "Failed to assign permissions.";
        }


    }

    if (isset($_POST['change_user_role'])) {
        $userId = $_POST['user_id'];
        $newRoleId = $_POST['new_role_id'];

        if (changeUserRole($userId, $newRoleId, $conn)) {
            $_SESSION['success_message'] = "User role updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update user role.";
        }
    }

    header('Location: /manage-user.php');
    exit;
}

// Fetch roles and permissions
$roles =  getRoles($conn);
$permissions = getPermissions($conn);
$users = getUsers ($conn);
$users_roles= getUserAndRoles($conn);
var_dump($users_roles);


?>

<?php require 'includes/header.php' ?>



<h1 class="my-4">Admin Dashboard</h1>

<!-- Success and Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="row">
        <div class="alert alert-success col-4 d-flex justify-content-center">
            <?= $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="row">

        <div class="alert alert-danger col-4 d-flex justify-content-center"><?= $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
        </div>
    </div>
<?php endif; ?>

<div class="row">

    <div class="col-3">
        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dashboard</li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="account-info.php">Account information</a>
            </li>
            <li class="list-group-item">
                <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="orders.php">Orders history</a>
            </li>
            <?php if (hasPermission('view_product', $userPermissions)): ?>
                <li class="list-group-item">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="view-product.php">Product Management</a></li>
            <?php endif; ?>
            <?php if (hasPermission('manage_user', $userPermissions)): ?>
                <li class="list-group-item bg-secondary-subtle">
                    <a class="link-dark link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="manage-user.php">User Management</a></li>
            <?php endif ?>
        </ul>
    </div>

    <div class="col-9 border rounded py-3">

        <div class="row">

            <div class="col-6">
            <!-- Create Role -->
            <h4>Create New Role</h4>
            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="role_name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="role_name" name="role_name" required>
                </div>
                <button type="submit" name="create_role" class="btn btn-primary">Create Role</button>
            </form>
            </div>

            <div class="col-6">
            <h4>Assign Permissions to Role</h4>
            <form method="POST" class="mb-4">
                <div class="mb-3">
                    <label for="role_id" class="form-label">Select Role</label>
                    <select class="form-select" id="role_id" name="role_id" required>
                        <?php foreach ($roles as $role): ?>
                            <option
                                <?php if($role['id'] == 1): ?>
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
        </div>
        <div class="row">
            <div class="col-6">

                <!-- Change User Role -->
                <h3>Change User Role</h3>
                <form method="POST">
                    <div class="mb-3">


                        <label for="user_id" class="form-label">Select User: (Current Role)</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <?php foreach ($users_roles as $user_role): ?>
                                <option value="<?= $user_role['id'] ?>"
                                <?php if($user_role['username'] == 'admin'): ?>
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

        </div>

    </div>
</div>

<?php require 'includes/footer.php' ?>
