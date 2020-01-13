<?php

// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

// TODO: Do auth checks

$data = [
    "utility",
    "__v" => 0,
    "postcode" => "M1",
    "name" => "Nukes",
    "type" => "Nuclear",
    "classification" => "dangerous af",
    "_id" => "5e15ee9b665b2018d28f3c69",
];

API::createUtilities($data);
$data = API::createUtilities($data); //$DataArr??
echo json_encode($data);

//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);
