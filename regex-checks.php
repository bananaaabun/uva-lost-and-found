<?php

function validateEmail($email, $regex = "") {
    // Check 1
    $check1 = "/^[\w\-\+]+(\.[\w\-\+]+)*@[a-zA-Z\d\-]+(\.[a-zA-Z\d\-]+)+$/";
    if (!preg_match($check1, $email)) {
        return false;
    }
    // Check 2 - Optional
    if ($regex === "") {
        return true;
    }
    if (!preg_match($regex, $email)) {
        return false;
    }
    return true;
}

function validateUsername($username) {
    $check = "/^.+$/"; // Any character or more
    if (!preg_match($check, $username)) {
        return false;
    }
    else {
        return true;
    }
}

?>