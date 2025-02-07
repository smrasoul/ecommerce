<?php

require_once 'controllers/HomeController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/LoginController.php';
require_once 'middlewares/LoginMiddleware.php';
require_once 'controllers/LogoutController.php';
require_once 'controllers/SignupController.php';
require_once 'middlewares/SignupMiddleware.php';
require_once 'controllers/DashboardController.php';
require_once 'middlewares/UserMiddleware.php';
require_once 'controllers/AccountInfoController.php';
require_once 'controllers/OrdersHistoryController.php';
require_once 'controllers/EditAccountController.php';
require_once 'middlewares/EditAccountMiddleware.php';
require_once 'controllers/ProductManagementController.php';
require_once 'controllers/AddProductController.php';
require_once 'middlewares/ProductMiddleware.php';
require_once 'controllers/UserManagementController.php';
require_once 'middlewares/ChangePasswordMiddleware.php';
require_once 'controllers/ChangePasswordController.php';
require_once 'controllers/EditProductController.php';
require_once 'controllers/DeleteProductController.php';
require_once 'controllers/TestController.php';




add_route('GET', '/', 'showHomePage');
add_route('GET', '/product/(\d+)', 'showProductPage',['verifyProductMW'] );
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
add_route('GET', '/edit-product/(\d+)','showEditProductPage' ,['checkPermissionsMW', 'checkPMPermissionsMW', 'verifyProductMW']);
add_route('POST', '/edit-product/(\d+)', 'submitEditProductForm', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateEditProductMW', 'verifyProductMW']);
add_route('GET', '/delete-product/(\d+)', 'deleteProduct' , ['checkPermissionsMW', 'checkPMPermissionsMW', 'deleteProductMW']);
add_route('GET', '/test', 'showTestPage', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('POST', '/test', 'submitTestForm', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateTestMW']);

