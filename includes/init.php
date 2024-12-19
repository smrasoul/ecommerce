<?php

session_start();
require 'includes/db.php';
$conn = getDbConnection();
require 'includes/auth.php';
require 'includes/url.php';
require 'includes/product-functions.php';