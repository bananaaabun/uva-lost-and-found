<?php

// Write JSON for to the link

error_reporting(E_ALL);
ini_set("display_errors", 1);

include("../data-and-classes/Database.php");

$db = new Database();
    
$res = $db->query("select * from items;");

$items = json_encode($res);
    
echo $items;


?>
