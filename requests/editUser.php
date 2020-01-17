<?php

header("Content-Type: application/json");
session_start();
require_once "../Models/Role.php";
require_once "../Models/User.php";
spl_autoload_register(function ($className) {
    require_once "../Models/lib/$className.php";
});

$users = User::getAllusers();

echo json_encode($users);