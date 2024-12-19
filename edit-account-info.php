<?php

session_start();

require 'includes/db.php';
require 'includes/auth.php';
require 'includes/user-functions.php';
require 'includes/signup-functions.php';

$conn = getDbConnection();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'])  {
    $userPermissions = getUserPermissions($_SESSION['user_id'], $conn);
    var_dump($userPermissions);
}

$user_id = $_SESSION['user_id'];
var_dump($user_id);

$user = getUserinfo($conn, $user_id);
var_dump($user);

// Ensure the user is an admin
//if (!hasPermission('view_product', $userPermissions)) {
//    header('HTTP/1.1 403 Forbidden');
//    echo "You do not have permission to access this page.";
//    exit;
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    validateUser($firstName, $lastName, $email, $username, $password);
    checkEmailAvailability($email, $conn);
    checkUsernameAvailability($username, $conn);
    $formFeedback = userFeedback();

    if (empty($formFeedback)) {
        $updateSuccess = updateUserInfo($conn, $user_id, $firstName, $lastName, $email, $username, $password);
        if ($updateSuccess) {
            $_SESSION['success_message'] = 'Account information updated successfully.';
            header('Location: /account-info.php');
            exit;
        } else {
            $_SESSION['error_message'] = 'An error occurred while updating your account information.';
        }
    }

}

?>

<?php require 'includes/header.php' ?>

<h1 class="my-4">Edit Account Information</h1>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
<?php endif; ?>

<form method="POST" action="edit-account-info.php">
    <div class="row mb-4">
        <div class="row col-6">
            <label for="firstName" class="col-4 fw-bold">First Name</label>
            <div class="col-8">
                <input type="text" class="form-control <?= isset($formFeedback['firstName']) ? 'is-invalid' : '' ?>"
                       id="firstName" name="firstName" value="<?= $user['first_name'] ?>">
                <?php if (isset($formFeedback['firstName'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['firstName'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row col-6">
            <label for="lastName" class="col-4 fw-bold">Last Name</label>
            <div class="col-8">
                <input type="text" class="form-control <?= isset($formFeedback['lastName']) ? 'is-invalid' : '' ?>"
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
                <input type="email" class="form-control <?= isset($formFeedback['email']) ? 'is-invalid' : '' ?>"
                       id="email" name="email" value="<?= $user['email'] ?>">
                <?php if (isset($formFeedback['email'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['email'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="row col-6">
            <label for="username" class="col-4 fw-bold">Username</label>
            <div class="col-8">
                <input type="text" class="form-control <?= isset($formFeedback['username']) ? 'is-invalid' : '' ?>"
                       id="username" name="username" value="<?= $user['username'] ?>">
                <?php if (isset($formFeedback['username'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['username'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row col-6">
            <label for="password" class="col-4 fw-bold">Password</label>
            <div class="col-8">
                <input type="password" class="form-control <?= isset($formFeedback['password']) ? 'is-invalid' : '' ?>"
                       id="password" name="password">
                <?php if (isset($formFeedback['password'])) : ?>
                    <div class="invalid-feedback"><?= $formFeedback['password'] ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-danger">
            <a class="link-dark link-underline-opacity-0" href="account-info.php">Cancel</a>
        </button>
        <button type="submit" class="btn btn-outline-success ms-4">Save</button>
    </div>
</form>

<?php require 'includes/footer.php'; ?>
