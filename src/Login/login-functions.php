<?php

function validateLogin($username, $password)
{
    if ($username == '') {
        $_SESSION['login_errors']['username_error'] = "Username is required.";
    }
    if ($password == '') {
        $_SESSION['login_errors']['password_error'] = "Password is required.";
    }
}

function authenticateUser($username, $password, $conn) {
    // Fetch user record
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['flash']['auth_error'] = "Invalid username or password.";
        return false;
    }

    return $user; // Return user details if authenticated
}

function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    session_regenerate_id(true);
    $_SESSION['is_logged_in'] = true;
}

function processLogin($username, $password, $conn)
{
    if (empty($_SESSION['login_errors'])) {
        $result = authenticateUser($username, $password, $conn); // Check if authentication was successful
        if ($result) {
            loginUser($result); // Log the user in
            redirect("/dashboard.php");
            exit;
        }
    }

        function loginFeedback(){
            $formFeedback = '';
            if(isset($_SESSION['login_errors'])) {
                $formFeedback = $_SESSION['login_errors'];
                unset($_SESSION['login_errors']);
            }
            return $formFeedback;
        }
    }
