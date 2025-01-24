<?php
require_once 'models/LoginModel.php';
require_once 'views/login/login_view.php';
require_once 'services/UserValidationService.php';

function processLogin($username, $password, $conn) {
    if (empty($_SESSION['login_errors'])) {
        $user = authenticateUser($username, $password, $conn); // Check if authentication was successful
        if ($user) {
            loginUser($user); // Log the user in
            redirect("/dashboard.php");
            exit;
        }
    }
}

function showLoginPage($conn) {
    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
        header('HTTP/1.1 403 Forbidden');
        echo "You are already logged in.";
        exit;
    }

    $username = '';
    $formFeedback = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        validateLogin($username, $password);
        processLogin($username, $password, $conn);
        $formFeedback = loginFeedback();
    }

    $flash_message = '';
    if (isset($_SESSION['flash'])) {
        $flash_message = $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    // Pass $username to the View
    renderLoginPage($flash_message, $username, $formFeedback);
}