<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once "ItemController.php";

$item_controller = new ItemController($_GET);

$item_controller->run();

?>