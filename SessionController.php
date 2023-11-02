<?php

include_once "data-and-classes/Database.php";

class SessionController {

    private $input = [];

    private  $db;

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();

        $this->db = new Database();
        
        $this->input = $input;

        $this->getUserItems();
    }

    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run() {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "login":
                $this->login();
                break;
            case "newusername":
                $this->changeUsername();
                break;
            case "logout":
                $this->logout();
            default:
                break;
        }

    }

    /**
     * Populate the session with the user's items.
     */
    public function getUserItems() {
        if(!empty($_SESSION["email"])) {
            $id_res = $this->db->query("select user_id from users where email = $1;", $_SESSION["email"]);
            $id = $id_res[0]["user_id"];
            $_SESSION["user_items"] = $this->db->query("select * from items where user_id = $1;", $id);
        }
    }

    public function addCookies() {
        $cookie_name = "username";
        $cookie_value = $_SESSION["username"];
        setcookie($cookie_name, $cookie_value, time() + 90000, "/");
        $cookie_name = "email";
        $cookie_value = $_SESSION["email"];
        setcookie($cookie_name, $cookie_value, time() + 90000, "/");
    }

    /**
     * Handle user registration and log-in
     */
    public function login() {

        $_SESSION["message"] = "";
        $_SESSION["condition"] = "";

        include("helper/regex-checks.php");

        if(isset($_POST["username"]) && !empty($_POST["username"]) &&
        isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["password"]) && !empty($_POST["password"])) {
            // Validate inputs
            if (validateEmailAndUsername($_POST["email"], $_POST["username"])) {
                // Check if user is in database
                $res =  $this->db->query("select * from users where email = $1;", $_POST["email"]);
                if (empty($res)) {
                    // User was not there, so insert them
                    $timestamp = date("Y-m-d H:i:s");
                     $this->db->query("insert into users (username, email, password, last_login) values ($1, $2, $3, $4);",
                        $_POST["username"], $_POST["email"],
                        password_hash($_POST["password"], PASSWORD_DEFAULT), $timestamp);
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["last_login"] = $timestamp;
                    $_SESSION["message"] = "Welcome {$_SESSION["username"]}! This is your first time logging in!";
                    $_SESSION["condition"] = "good";
                    // Send user to the appropriate page (home)
                    $this->addCookies();
                    session_write_close();
                    header("Location: index.php");
                    exit;
                } else {
                    // User was in the database, verify password & username
                    if ($_POST["username"] == $res[0]["username"]) {
                        if (password_verify($_POST["password"], $res[0]["password"])) {
                            // Password was correct
                            $timestamp = date("Y-m-d H:i:s");
                            $_SESSION["username"] = $res[0]["username"];
                            $_SESSION["email"] = $res[0]["email"];
                            $_SESSION["last_login"] = $res[0]["last_login"];
                            // Update last login in the database after grabbing that variable
                            $this->db->query("update users set last_login = $1 where email = $2;", $timestamp , $_SESSION["email"]);
                            $_SESSION["message"] = "Welcome {$_SESSION["username"]}! You were last here on {$_SESSION["last_login"]}.";
                            $_SESSION["condition"] = "neutral";
                            $this->addCookies();
                            session_write_close();
                            header("Location: index.php");
                            exit;
                        } else {
                            // Wrong password
                            $_SESSION["message"] = "Incorrect password.";
                            $_SESSION["condition"] = "bad";
                            session_write_close();
                            header("Location: login.php");
                            exit;
                        }
                    }
                    // Wrong username
                    $_SESSION["message"] = "Incorrect username.";
                    $_SESSION["condition"] = "bad";
                    session_write_close();
                    header("Location: login.php");
                    exit;
                }
            }
        } else {
            // Not everything filled out
            $_SESSION["message"] = "Please fill out all fields!";
            $_SESSION["condition"] = "bad";
            session_write_close();
            header("Location: login.php");
            exit;
        }
        // If something went wrong, show the welcome page again
        $_SESSION["message"] = "Something went wrong. Please refresh the page and try again.";
        $_SESSION["condition"] =  "bad";
        session_write_close();
        header("Location: login.php");
        exit;
    }
    /**
     * changeUsername
     * 
     * Change username, modifying it for both the session and the database.
     */
    public function changeUsername() {
        if(!empty($_SESSION["email"])) {
            $old = $_SESSION["username"];
            if(!empty($_POST["username"])) {
                // If logged in and correct submission allow change.
                $new = $_POST["username"];
                if ($old != $new) {
                    // If the username is actually being changed
                    $_SESSION["message"] = "Username changed from {$old} to {$new}.";
                    $_SESSION["condition"] = "neutral";
                    $this->db->query("update users set username = $1 where email = $2;", $new , $_SESSION["email"]);
                    $_SESSION["username"] = $new;
                    $this->addCookies();
                }
                else {
                    // Username isn't changed.
                    $_SESSION["message"] = "Username needs to be different.";
                    $_SESSION["condition"] = "bad";
                }
            }
            else {
                // Username is not filled out
                $_SESSION["message"] = "Please enter a new username.";
                $_SESSION["condition"] = "bad";
            }
        }
        else {
            // User tries to access this withot logging in
            $_SESSION["message"] = "Must be logged in.";
            $_SESSION["condition"] = "bad";
        }
        session_write_close();
        header("Location: login.php");
        exit;
    }


    /**
     * Log out the user
     */
     public function logout() {
        // $this->db->query("update users set score = $1 where email = $2;", $_SESSION["score"], $_SESSION["email"]);
        session_destroy();
        session_start();
    }

    /**
     * Return home
     */
    public function goHome() {
        header("Location: index.php");
        exit;
    }

}