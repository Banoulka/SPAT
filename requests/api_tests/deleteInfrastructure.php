<?php

// Bootstrap
header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

// TODO: Do auth checks
$allInfra = API::getAllInfrastructure();
$rand = rand(0, count($allUtilities)-1);
$uteToDelete = $allInfra[$rand];
$data = API::deleteInfrastructure($uteToDelete->_id); //$id??
echo json_encode($data);


//$data = new stdClass();
//$data->error = "You do not have authorisation for this";
//echo json_encode($data);
