<?php

// Write JSON for to the link

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("../data-and-classes/Database.php");

$db = new Database();

if(!empty($_SESSION["email"])) {

    $items = json_encode($db->query("select * from items"));

    echo $items;

}

?>
