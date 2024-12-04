<?php

session_start(); // Start or resume the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home or login page
header("Location: /index.php");
exit;
