<?php

// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

// TODO: Do auth checks

$data = [
    "postcode" => "M1",
    "name" => "Nukes",
    "type" => "Electric",
    "classification" => "Critical",
];


$res = API::createUtilities($data);

echo json_encode($res);

//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);