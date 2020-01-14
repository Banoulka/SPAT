<?php

// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

if (Authorisation::hasAuth("edit")) {
    $data = [
        "name" =>"Wetherspoons",
        "type" => "Commercial",
        "postcode" => "M1 234",
        "city" => "Manchester",
        "size_m2" => 3000,
        "maxOccupants"=> 100,
        "value" => 120000,
    ];
    $data = API::createBuilding($data); //$DataArr??
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}