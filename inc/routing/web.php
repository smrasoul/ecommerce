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
require 'controllers/UserManagementController.php';
require 'middlewares/ChangePasswordMiddleware.php';
require 'controllers/ChangePasswordController.php';
require 'controllers/EditProductController.php';
require 'controllers/DeleteProductController.php';
require 'controllers/TestController.php';




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
add_route('POST', '/edit-account', 'submitEditAccountForm', ['verifyUserMW','checkPermissionsMW', 'validateEditAccountMW']);
add_route('GET', '/product-management', 'showProductManagementPage', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('GET', '/add-product', 'showAddProductPage', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('POST', '/add-product', 'submitAddProductForm', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateProductMW']);
add_route('GET', '/user-management', 'showUserManagementPage', ['checkPermissionsMW', 'checkUMPermissionMW']);
add_route('POST', '/user-management', 'submitUserManagementForm', ['checkPermissionsMW', 'checkUMPermissionMW']);
add_route('GET', '/change-password', 'showChangePasswordPage', ['verifyUserMW', 'checkPermissionsMW']);
add_route('POST', '/change-password', 'submitChangePasswordPage', ['verifyUserMW', 'checkPermissionsMW', 'validateChangePasswordMW']);
add_route('GET', '/edit-product/(\d+)','showEditProductPage' ,['checkPermissionsMW', 'checkPMPermissionsMW', 'editProductMW']);
add_route('POST', '/edit-product/(\d+)', 'submitEditProductForm', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateEditProductMW', 'editProductMW']);
add_route('GET', '/delete-product/(\d+)', 'deleteProduct' , ['checkPermissionsMW', 'checkPMPermissionsMW', 'deleteProductMW']);
add_route('GET', '/test', 'showTestPage', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('POST', '/test', 'submitTestForm', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateTestMW']);
