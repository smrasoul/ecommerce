<?php

session_start();
require_once 'services/DatabaseService.php';
$conn = getDbConnection();
require_once 'services/ViewService.php';
require_once 'services/UrlService.php';
require_once 'services/MediaService.php';
require_once 'services/FlashMessageService.php';
require_once 'services/HashingService.php';
require_once 'inc/routing/routing.php';  // Load routing system
require_once 'inc/routing/web.php';  // Load defined routes

handle_request(); // Process the current request

