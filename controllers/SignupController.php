<?php

require 'models/SignupModel.php';
require 'models/UserModel.php';

function showSignupPage(){

    $activeForm = 'Signup';
    renderView('signup_view',['activeForm'=>$activeForm]);

}

function submitSignupForm(){

    $user['first_name'] = htmlspecialchars($_POST['firstName']);
    $user['last_name'] = htmlspecialchars($_POST['lastName']);
    $user['email'] = htmlspecialchars($_POST['email']);
    $user['username'] = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $retypePassword = htmlspecialchars($_POST['retypePassword']);

    $hashedPassword = hashPassword($password);
    $signup = signUp($user['first_name'], $user['last_name'], $user['email'], $user['username'], $hashedPassword);

    setFlashMessage(['signup' => $signup]);
    redirect('/login');

}