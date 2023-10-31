<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($classname) {
    include "data-and-classes/$classname.php";
});

include("Controller.php");

$controller = new Controller($_GET);

$controller->run();