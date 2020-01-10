<?php
// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

session_destroy();
Route::redirect("index.php");


