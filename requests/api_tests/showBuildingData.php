<?php

// Bootstrap
header("Content-Type: application/json");
require_once "../../Models/Role.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});
// End Bootstrap

if ($succeeded = Authorisation::hasAuth("get")) {

    // Get all the current data from this endpoint
    $data = API::getAllBuildings();
    $data = array_filter($data, function($item) {
        // If the group ID is not set, assume access is public and add it
        if (isset($item->groupId)) {
            // If the group ID IS set, loop through the current users team ids
            // If any team ID from the user exists in the item, we can assume
            // that the user is allowed access.
            $currentIDS = explode(",", $item->groupId);

            // If the current user is a mocking a user, get their teams
            // If not, get the currently logged in users teams.
            $groupIDs = Authentication::isMocking() ?
                Authentication::mockedUser()->teams()->listIDs() :
                Authentication::User()->teams()->listIDs();

            // Loop through each team that the user is in and look for it
            // in the current building 'item' team list
            foreach ($groupIDs as $id) {
                if (in_array($id, $currentIDS)) {
                    return $item;
                }
            }

            // If the users groups ids have not been found return nothing, access is private
            return null;
        }
        return $item;
    });
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}

SessionLog::createLog([
    "endpoint" => "Building - Get All",
    "succeeded" => $succeeded ? 1 : 0
]);
