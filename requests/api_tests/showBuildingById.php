<?php

// Bootstrap
header("Content-Type: application/json");
require_once "../../Models/Role.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

if ($succeeded = Authorisation::hasAuth("get")) {
    $data = API::getBuildingByID("5e18935e1fb6ab001271a82a");
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}

SessionLog::createLog([
    "endpoint" => "Building - Get by ID",
    "succeeded" => $succeeded ? 1 : 0
]);

