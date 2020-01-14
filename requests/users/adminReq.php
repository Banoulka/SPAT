<?php

header("Content-Type: application/json");
require_once "../../Models/User.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

require_once "../../Models/User.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, TRUE);

    $accept = $input["acceptance"];
    $userID = $input["id"];

    if ($accept) {

    } else {

    }

    echo json_encode($input["acceptance"]);
}
