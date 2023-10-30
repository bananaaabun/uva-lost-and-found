<?php

class Controller {

    private $input = [];

    private  $db;

    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();
        $this->db = new Database();
        
        $this->input = $input;
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
            case "showlogin":
                $this->showLogin();
                break;
            case "login":
                $this->login();
                break;
            case "logout":
                $this->logout();
            default:
                $this->showHome();
                break;
        }

    }

    /**
     * Show the home page to the user.
     */
    public function showHome() {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>".$this->errorMessage."</p>";
        include("home.php");
    }

    public function showLogin() {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>".$this->errorMessage."</p>";
        include("login.php");
    }

    /**
     * Handle user registration and log-in
     */
    public function login() {
        $message = "";

        include("regex-checks.php");

        if(isset($_POST["username"]) && !empty($_POST["username"]) &&
        isset($_POST["email"]) && !empty($_POST["email"]) &&
        isset($_POST["password"]) && !empty($_POST["password"])) {
            // Validate inputs
            if (validateEmailAndUsername($_POST["email"], $_POST["username"])) {
                // Check if user is in database
                $res =  $this->db->query("select * from users where email = $1;", $_POST["email"]);
                if (empty($res)) {
                    // User was not there, so insert them
                     $this->db->query("insert into users (username, email, password, last_login) values ($1, $2, $3, $4);",
                        $_POST["username"], $_POST["email"],
                        password_hash($_POST["password"], PASSWORD_DEFAULT), date("Y-m-d H:i:s"));
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["last_login"] = date("Y-m-d H:i:s");
                    // Send user to the appropriate page (home)
                    // header("Location: ?command");
                    include("home.php");
                    return;
                } else {
                    // User was in the database, verify password
                    if (password_verify($_POST["password"], $res[0]["password"])) {
                        // Password was correct
                        $_SESSION["username"] = $res[0]["username"];
                        $_SESSION["email"] = $res[0]["email"];
                        $_SESSION["last_login"] = $res[0]["last_login"];
                        include("home.php");
                        return;
                    } else {
                        $message .= "<p class='alert alert-danger'> Incorrect Passwor. </p>";
                        include("login.php");
                        return;
                    }
                }
            }
        } else {
            $message .= "<p class='alert alert-danger'> All fields are required. </p>";
            include("login.php");
            return;
        }
        // If something went wrong, show the welcome page again
        $message .= "<p class='alert alert-danger'> Something went wrong. Please try again. </p>";
        include("login.php");
        return;
    }

    /**
     * Log out the user
     */
     public function logout() {
        // $this->db->query("update users set score = $1 where email = $2;", $_SESSION["score"], $_SESSION["email"]);
        session_destroy();
        session_start();
    }
}