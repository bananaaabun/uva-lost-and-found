<?php
include 'Config.php';
include 'Database.php';

// Fetch Lost Items from Database

$db = new Database();
$query = "SELECT * FROM items";
try {
    $items = $db->query($query);
} catch (Exception $e) {
    echo "Error querying the database.";
    exit;
}

