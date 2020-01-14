<?php


// Bootstrap
header("Content-Type: application/json");
require_once "../../Models/Role.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

if (Authorisation::hasAuth("edit")) {
    $data = [
        "postcode" => "M1",
        "totalHealthNeeds" => 1500,
        "totalMobilityNeeds" => 5000,
        "totalElderly" => 5000,
        "totalPopulation" => 12000,
    ];
    $data = API::createDemographics($data); //$DataArr??
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}
