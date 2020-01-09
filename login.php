<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

if (Authentication::isLoggedIn()) {
    Route::redirect("index.php");
} else {
    $errors = [];

    if (isset($_POST["submit"])) {
        $formData = [
            "username" => htmlentities($_POST["username"]),
            "password" => htmlentities($_POST["password"]),
        ];

        $errors = Authentication::validateAndLoginUser($formData["username"], $formData["password"]);

        if (!$errors) {
            //TODO: redirect somewhere
        }
    }

    require_once "Views/login.phtml";
}