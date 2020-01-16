<?php

// Bootstrap
header("Content-Type: application/json");
require_once "../../Models/Role.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});
if ($succeeded = Authorisation::hasAuth("edit")) {
    $data = [
        "name" =>"Wetherspoons",
        "type" => "Commercial",
        "postcode" => "M1 234",
        "city" => "Manchester",
        "size_m2" => 3000,
        "maxOccupants"=> 100,
        "value" => 120000,
    ];
//    if (empty(Authentication::User()->teams()->list())) {
//
//    }
    $data = API::createBuilding($data); //$DataArr??
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}

SessionLog::createLog([
    "endpoint" => "Building - Create",
    "succeeded" => $succeeded ? 1 : 0
]);