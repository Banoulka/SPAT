<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});


require_once ("Views/Template/header.phtml");

















require_once ("Views/Template/footer.phtml");