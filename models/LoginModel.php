<?php
function getUserInfoByUsername ($username) {

    global $conn;

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);

}

function loginUser($user) {
    $_SESSION['user_id'] = $user['id'];
    session_regenerate_id(true);
    $_SESSION['is_logged_in'] = true;
}