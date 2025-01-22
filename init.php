<?php

session_start();
require 'services/DatabaseService.php';
$conn = getDbConnection();
require 'services/AuthService.php';
require 'services/UrlService.php';