<?php

header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

require_once "../../Models/Role.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, TRUE);
    $msg = "";

    $role = Role::getRole($input["id"]);

    $permission = $input["permission"];
    $checked = $input["change"];

    if ($checked) {
        $role->addPermission($permission);
        $msg = "Added permission $permission to role $role->role_name";
    } else {
        $role->removePermission($permission);
        $msg = "Removed permission $permission to role $role->role_name";
    }

    echo json_encode($msg);
}

