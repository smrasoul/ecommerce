<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';
require 'src/User/Validation/user-validation.php';

$userPermissions = checkUserAccess($conn, 'manage_user');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['create_role'])) {

        $roleName = htmlspecialchars(trim($_POST['role_name']));
        processNewRole($conn, $roleName);

    }

    if (isset($_POST['assign_permissions'])) {

        $roleId = $_POST['role_id'];
        $permissionIds = $_POST['permissions'] ?? [];
        processNewRolePermissions($roleId, $permissionIds, $conn);

    }

    if (isset($_POST['change_user_role'])) {

        $userId = $_POST['user_id'];
        $newRoleId = $_POST['new_role_id'];

        if (changeUserRole($userId, $newRoleId, $conn)) {
            $_SESSION['success_message'] = "Signup role updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update user role.";
        }
    }

    header('Location: /manage-user.php');
    exit;
}


$roles =  getRoles($conn);
$permissions = getPermissions($conn);
$users = getUsers ($conn);
$users_roles= getUserAndRoles($conn);
//var_dump($users_roles);
$activePage = 'manage-user';

$rolePermissions = getRolePermissions($conn);
var_dump($rolePermissions);



?>

<?php require 'includes/View/header.php' ?>



<h1 class="my-4">Admin Dashboard</h1>

<?php require 'src/User/View/manage-flash.php'; ?>

<div class="row">

    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded py-3">
        <div class="row">
            <?php require 'src/User/View/create-role.php' ?>
            <?php require 'src/User/View/permission.php' ?>
        </div>
        <div class="row">
            <?php require 'src/User/View/change-role.php' ?>
        </div>
    </div>

</div>

<?php require 'includes/View/footer.php' ?>
