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

require 'controllers/OrdersHistoryController.php';

require 'controllers/EditAccountController.php';
require 'middlewares/EditAccountMiddleware.php';

require 'controllers/ProductManagementController.php';

require 'controllers/AddProductController.php';
require 'middlewares/ProductMiddleware.php';




add_route('GET', '/', 'showHomePage');

add_route('GET', '/login', 'showLoginPage', ['checkLoginStatusMW']);
add_route('POST', '/login', 'submitLoginForm', ['checkLoginStatusMW', 'validateLoginMW']);

add_route('GET', '/logout', 'logout');

add_route('GET', '/signup', 'showSignupPage', ['checkLoginStatusMW']);
add_route('POST', '/signup', 'submitSignupForm', ['checkLoginStatusMW', 'validateSignupMW']);

add_route('GET', '/dashboard', 'showDashboardPage', ['verifyUserMW', 'checkPermissionsMW']);

add_route('GET', '/account-info','showAccountInfoPage', ['verifyUserMW', 'checkPermissionsMW']);

add_route('GET', '/orders-history', 'showOrdersHistoryPage', ['verifyUserMW', 'checkPermissionsMW']);

add_route('GET', '/edit-account', 'showEditAccountPage', ['verifyUserMW', 'checkPermissionsMW']);
add_route('POST', '/edit-account', 'submitEditAccountForm', ['checkPermissionsMW', 'validateEditAccountMW']);

add_route('GET', '/product-management', 'showProductManagementPage', ['verifyUserMW', 'checkPermissionsMW']);

add_route('GET', '/add-product', 'showAddProductPage', ['verifyUserMW', 'checkPermissionsMW']);
add_route('POST', '/add-product', 'submitAddProductForm', ['verifyUserMW','checkPermissionsMW', 'validateProductMW']);