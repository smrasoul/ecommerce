<?php

require 'controllers/HomeController.php';
require 'controllers/LoginController.php';
require 'middlewares/LoginMiddleware.php'; // Include your middleware

add_route('GET', '/', 'showHomePage');
add_route('GET', '/login', 'showLoginPage', ['checkLoginStatusMW']);
add_route('POST', '/login', 'submitLoginForm', ['checkLoginStatusMW', 'validateLoginMW']);

