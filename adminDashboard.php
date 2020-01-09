<?php

// Bootstra
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

//var_dump(Authentication::isAdmin());
//var_dump(User::getAllusers());

if (Authentication::isAdmin()) {

    $users = User::getAllusers();

    require_once "Views/adminDashboard.phtml";
} else {
    //TODO: Require the authorsiation error page
    echo "no access";
}