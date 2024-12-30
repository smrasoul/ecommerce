<?php

require 'includes/init.php';
require 'src/User/Function/user-functions.php';
require 'src/User/Validation/user-validation.php';

$userPermissions = checkUserAccess($conn);

$user_id = $_SESSION['user_id'];
//var_dump($user_id);

$user = getUserinfo($conn, $user_id);
//var_dump($user);

$originalUsername = $user['username'];
$originalEmail = $user['email'];

$activePage = 'account-info';
$activeForm = 'edit-account-info';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);

    validateUserForm($user['first_name'], $user['last_name'],  $user['email'], $user['username']);
    if (!($originalEmail == $user['email'])) {
        checkEmailAvailability($user['email'], $conn);
    }
    if (!($originalUsername == $user['username'])) {
        checkUsernameAvailability($user['username'], $conn);
    }

    $formFeedback = userFeedback();

    if (empty($formFeedback)) {
        $updateSuccess = updateUserInfo($conn, $user['first_name'], $user['last_name'], $user['email'], $user['username'], $user_id);
        if ($updateSuccess) {
            $_SESSION['success_message'] = 'User information updated successfully.';
            header('Location: /account-info.php');
            exit;
        } else {
            $_SESSION['error_message'] = 'An error occurred while updating your account information.';
        }
    }

}

?>

<?php require 'includes/View/header.php' ?>

<h1 class="my-4">Dashboard</h1>

<div class="row">
    <div class="col-3">
        <?php require 'includes/View/sidebar.php' ?>
    </div>

    <div class="col-9 border rounded p-4">
        <?php require 'src/User/View/user-form.php' ?>
    </div>

    <?php require 'includes/View/footer.php'; ?>
