<?php


require 'controllers/HomeController.php';
require 'controllers/LoginController.php';

add_route('GET', '/', function() use ($products) {
    showHomePage($products);
});

add_route('GET', '/login', function() use ($flash_message, $username, $formFeedback) {
    checkLoginStatus();
    showLoginPage($flash_message, $username, $formFeedback);
});

add_route('POST', '/login', function() {
    checkLoginStatus();

});