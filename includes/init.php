<?php

session_start();

require 'includes/Database/db.php';
$conn = getDbConnection();

require 'includes/Auth/auth.php';
require 'includes/url.php';