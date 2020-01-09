<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

//var_dump(Authentication::isAdmin());
//var_dump(User::getAllusers());

if (Authentication::isAdmin()) {

    $users = User::getAllusers();

    $page = "addRole";

    if (isset($_GET["tab"])) {
        $page = $_GET["tab"];
    }

    //var_dump(Authentication::User()->roles());

    require_once "Views/adminDashboard.phtml";
} else {
    //TODO: Require the authorization error page
    echo "no access";
}
