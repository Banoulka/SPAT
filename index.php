<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
   require_once "Models/lib/$className.php";
});

require_once "Models/User.php";
require_once "Models/Role.php";
require_once "Models/Group.php";

require_once "Views/index.phtml";