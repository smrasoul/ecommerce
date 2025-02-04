<?php

require 'controllers/HomeController.php';


require 'controllers/LoginController.php';
require 'middlewares/LoginMiddleware.php';

require 'controllers/LogoutController.php';

require 'controllers/SignupController.php';
require 'middlewares/SignupMiddleware.php';

require 'controllers/DashboardController.php';

require 'middlewares/UserMiddleware.php';

require 'controllers/AccountInfoController.php';


add_route('GET', '/', 'showHomePage');

add_route('GET', '/login', 'showLoginPage', ['checkLoginStatusMW']);
add_route('POST', '/login', 'submitLoginForm', ['checkLoginStatusMW', 'validateLoginMW']);

add_route('GET', '/logout', 'logout');

add_route('GET', '/signup', 'showSignupPage', ['checkLoginStatusMW']);
add_route('POST', '/signup', 'submitSignupForm', ['checkLoginStatusMW', 'validateSignupMW']);

add_route('GET', '/dashboard', 'showDashboardPage', ['verifyUserMW', 'checkPermissionsMW']);

add_route('GET', '/account-info','showAccountInfoPage', ['verifyUserMW', 'checkPermissionsMW']);