<?php

header("Content-Type: application/json");
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});

require_once "../../Models/User.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, TRUE);
    $msg = "No uid set";

    if (isset($input["uid"])) {
        $user = User::findByID($input["uid"]);
        if ($user) {
            $username = $user->username();
            $user->remove();
            $msg = "User $username removed succesfully";
        } else {
            $msg = "User not found";
        }
    }

    echo json_encode($msg);
}


