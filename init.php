<?php

session_start();
require 'services/DatabaseService.php';
$conn = getDbConnection();
require 'services/ViewService.php';
require 'services/AuthService.php';
require 'services/UrlService.php';
require 'inc/routing/routing.php';  // Load routing system
require 'inc/routing/web.php';  // Load defined routes
require 'services/LoginService.php';