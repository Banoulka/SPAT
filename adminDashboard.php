<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

var_dump(Authentication::isAdmin());
var_dump(User::getAllusers());

require_once "Views/adminDashboard.phtml";