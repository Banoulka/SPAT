<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

if (Authentication::isLoggedIn()) {
    Route::redirect("index.php");
} else {
    if (isset($_POST["submit"])) {
        $formData = [
            "username" => $_POST["username"],
            "password" => $_POST["password"],
            "confirm_password" => $_POST["confirm_password"]
        ];

        $validation = new Validation();
        $validation->name("username")->required()->length(0, 20)->unique("users", "username");
        $validation->name("confirm_password")->required();
        $validation->name("password")->required()->equal($formData["confirm_password"]);

        if ($validation->isSuccess()) {
            // Send requests
            User::createAdminRequest($formData);
            $message = "Admin user request sent successfully, please contact an admin to approve";
        } else {
            $errors = $validation->getErrors();
        }
    }

    require_once "Views/signup.phtml";
}


