<?php

include("regex-checks.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate
    if (!validateUsername($username) || !validatePassword($password)) {
        echo "Try again!";
    }

    // Database interactions

    // Update session

    // Redirect

}
?>