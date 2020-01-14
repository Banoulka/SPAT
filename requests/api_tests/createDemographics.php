<?php


// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

// TODO: Do auth checks

$data = [
    "demographic",
    "__v" => 0,
    "postcode" => "M1",
    "totalHealthNeeds" => 1500,
    "totalMobilityNeeds" => 5000,
    "totalElderly" => 5000,
    "totalPopulation" => 12000,
    "_id" => "5e15eab306f6e7159f259e5c",
];

API::createBuilding($data);
$data = API::createDemographics($data); //$DataArr??
echo json_encode($data);

//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);
