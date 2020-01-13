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
    "totalHealthNeeds" => 100,
    "totalMobilityNeeds" => 50600,
    "totalElderly" => 50090,
    "totalPopulation" => 182000,
    "_id" => "5e15eab306f6e7159f259e5c",
];

API::createBuilding($data);
$data = API::createDemographics($data); //$DataArr??
echo json_encode($data);

//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);
