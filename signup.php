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
            "username" => htmlentities($_POST["username"]),
            "password" => htmlentities($_POST["password"]),
            "confirm_password" => htmlentities($_POST["confirm_password"]),
            "email" => htmlentities($_POST["email"])
        ];

        $validation = new Validation();
        $validation->name("Username")->value($formData["username"])->required()->length(0, 20)->unique("users", "username");
        $validation->name("Confirm Password")->value($formData["confirm_password"])->required();
        $validation->name("Email")->value($formData["email"])->required()->type(FILTER_VALIDATE_EMAIL)->unique("admin_requests", "email");
        $validation->name("Password")->value($formData["password"])->required()->equal($formData["confirm_password"]);

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


