<?php

require_once 'controllers/HomeController.php';

require_once 'controllers/ProductController.php';
require_once 'middlewares/ProductMiddleware.php';

require_once 'controllers/LoginController.php';
require_once 'middlewares/LoginMiddleware.php';
require_once 'controllers/LogoutController.php';
require_once 'controllers/SignupController.php';
require_once 'middlewares/SignupMiddleware.php';


require_once 'controllers/DashboardController.php';


require_once 'middlewares/UserMiddleware.php';

require_once 'controllers/AccountController.php';
require_once 'middlewares/AccountMiddleware.php';

require_once 'controllers/UserManagementController.php';
require_once 'controllers/OrdersHistoryController.php';




add_route('GET', '/', 'showHomePage');



// Product
add_route('GET', '/product/(\d+)', 'showProductPage',['verifyProductMW'] );
add_route('GET', '/admin/product', 'showProductManagement', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('GET', '/admin/product/add', 'showCreateProduct', ['checkPermissionsMW', 'checkPMPermissionsMW']);
add_route('POST', '/admin/product/add', 'submitCreateProduct', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateProductMW']);
add_route('GET', '/admin/product/edit/(\d+)','showUpdateProduct' ,['checkPermissionsMW', 'checkPMPermissionsMW', 'verifyProductMW']);
add_route('POST', '/admin/product/edit/(\d+)', 'submitUpdateProduct', ['checkPermissionsMW', 'checkPMPermissionsMW', 'validateEditProductMW', 'verifyProductMW']);
add_route('GET', '/admin/product/delete/(\d+)', 'deleteProduct' , ['checkPermissionsMW', 'checkPMPermissionsMW', 'deleteProductMW']);




//Login, Logout & Signup
add_route('GET', '/login', 'showLoginPage', ['checkLoginStatusMW']);
add_route('POST', '/login', 'submitLoginForm', ['checkLoginStatusMW', 'validateLoginMW']);
add_route('GET', '/logout', 'logout');
add_route('GET', '/signup', 'showSignupPage', ['checkLoginStatusMW']);
add_route('POST', '/signup', 'submitSignupForm', ['checkLoginStatusMW', 'validateSignupMW']);




add_route('GET', '/user/dashboard', 'showDashboardPage', ['verifyUserMW', 'checkPermissionsMW']);




// User Account
add_route('GET', '/user/account','showAccountInfo', ['verifyUserMW', 'checkPermissionsMW']);
add_route('GET', '/user/orders-history', 'showOrdersHistory', ['verifyUserMW', 'checkPermissionsMW']);
add_route('GET', '/user/account/edit', 'showEditAccount', ['verifyUserMW', 'checkPermissionsMW']);
add_route('POST', '/user/account/edit', 'submitEditAccount', ['verifyUserMW','checkPermissionsMW', 'validateEditAccountMW']);
add_route('GET', '/user/account/password', 'showChangePassword', ['verifyUserMW', 'checkPermissionsMW']);
add_route('POST', '/user/account/password', 'submitChangePassword', ['verifyUserMW', 'checkPermissionsMW', 'validateChangePasswordMW']);

add_route('GET', '/admin/user-management', 'showUserManagementPage', ['checkPermissionsMW', 'checkUMPermissionMW']);
add_route('POST', '/admin/user-management', 'submitUserManagementForm', ['checkPermissionsMW', 'checkUMPermissionMW']);


