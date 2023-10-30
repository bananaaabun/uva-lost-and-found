<?php
include 'db_setup.php';

$query = "SELECT * FROM items";
$result = pg_query($dbconn, $query);
if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

while ($row = pg_fetch_array($result)) {
    echo '<div class="lost-item">';
    echo $row['name'] . ' (details)';
    echo '</div>';
}
?>