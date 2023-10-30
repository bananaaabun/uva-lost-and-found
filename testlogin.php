<?php

include("regex-checks.php");

function login($db) {

    echo "here";

    // need a name, email, and password
    if(isset($_POST["username"]) && !empty($_POST["username"]) &&
        isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["password"]) && !empty($_POST["password"])) {
            // Validate inputs
            if (validateEmailAndUsername($_POST["email"], $_POST["username"])) {
                // Check if user is in database
                $res = $db->query("select * from users where email = $1;", $_POST["email"]);
                if (empty($res)) {
                    // User was not there, so insert them
                    $db->query("insert into users (username, email, password, last_login) values ($1, $2, $3, $4);",
                        $_POST["username"], $_POST["email"],
                        password_hash($_POST["password"], PASSWORD_DEFAULT), date("Y-m-d H:i:s"));
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["last_login"] = date("Y-m-d H:i:s");
                    // Send user to the appropriate page (question)
                    include("home.php");
                    return;
                } else {
                    // User was in the database, verify password
                    if (password_verify($_POST["password"], $res[0]["password"])) {
                        // Password was correct
                        $_SESSION["username"] = $res[0]["username"];
                        $_SESSION["email"] = $res[0]["email"];
                        $_SESSION["last_login"] = $res[0]["last_login"];
                        include("home.php")
                        return;
                    } else {
                        $this->errorMessage = "Incorrect password.";
                        header("Location: login.html");
                    }
                }
            }
    } else {
        $this->errorMessage = "Name, email, and password are required.";
        header("Location: login.html");
    }
    // If something went wrong, show the welcome page again
    // $this->showWelcome();
    header("Location: login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login($this->db);
}

?>
