<?php

// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

// TODO: Do auth checks

$data = [
    "infrastructure",
    "__v" => 0,
    "postcode" => "M234 345",
    "type" => "tarmacked track",
    "name" => "M69 Ring roundabout",
    "classification" => "Critical",
    "_id" => "5e15c9614ef172660ea7ab4f"
];

API::createInfrastructure($data);
$data = API::createInfrastructure(); //$DataArr??
echo json_encode($data);

//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);
