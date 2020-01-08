<?php

require_once __DIR__ . "/../User.php";

class Authentication {

    private static $sessionID = "user";

    public static function isRole($roleName)
    {
        // Get role name,
        // Get role ID
        // Check against user roles
        return true;
    }

    public static function isLoggedIn()
    {
        return true;
    }
}