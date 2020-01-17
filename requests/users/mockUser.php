<?php


header("Content-Type: application/json");
require_once "../../Models/User.php";
require_once "../../Models/Role.php";
require_once "../../Models/Group.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, TRUE);

    $userID = $input["id"];
    $user = User::findByID($userID);
    $data = [];

    if (Authentication::User()->isAdmin() && $user) {
        // Start mocking
        $username = $user->username();
        $data["msg"] = "Started mocking $username";
        $data["username"] = $username;
        Authentication::startMocking($user);
    } else {
        Authentication::stopMocking();
        $data["msg"] = "Could not start mocking";
    }

    echo json_encode($data);
}
