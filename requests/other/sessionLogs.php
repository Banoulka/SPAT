<?php

header("Content-Type: application/json");
require_once "../../Models/User.php";
require_once "../../Models/lib/SessionLog.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, TRUE);

    $logs = SessionLog::getJSONLogs();

    echo json_encode($logs);
}