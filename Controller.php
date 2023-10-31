<?php
// include "db_setup.php";

class Controller
{

    private $input = [];

    private $db;

    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new Database();

        $this->input = $input;
    }

    /**
     * Run the server
     */
    public function run()
    {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch ($command) {
            // case "showlogin":
            //     $this->showLogin();
            //     break;
            // case "login":
            //     $this->login();
            //     break;
            // case "logout":
            //     $this->logout();

            case "lostItemsPage":
                $this->showLostItemsPage();
                break;
            case "makeRequest":
                $this->showMakeRequest();
                break;
            case "submitItem":
                $this->submitItem();
                break;
            default:
                $this->showHome();
                break;
        }

    }

    /**
     * Show the home page to the user.
     */
    public function showHome()
    {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>" . $this->errorMessage . "</p>";
        include("home.php");
    }

    /**
     * Show the make request page to the user.
     */
    public function showMakeRequest()
    {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>" . $this->errorMessage . "</p>";
        include("makeRequest.html");
    }

    /**
     * Show the lost items page to the user.
     */
    public function showLostItemsPage()
    {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>" . $this->errorMessage . "</p>";
        include("lostItemsPage.php");
    }

    // public function showLogin() {
    //     $message = "";
    //     if (!empty($this->errorMessage))
    //         $message .= "<p class='alert alert-danger'>".$this->errorMessage."</p>";
    //     include("login.php");
    // }

    // /**
    //  * Handle user registration and log-in
    //  */
    // public function login() {
    //     $message = "";

    //     include("regex-checks.php");

    //     if(isset($_POST["username"]) && !empty($_POST["username"]) &&
    //     isset($_POST["email"]) && !empty($_POST["email"]) &&
    //     isset($_POST["password"]) && !empty($_POST["password"])) {
    //         // Validate inputs
    //         if (validateEmailAndUsername($_POST["email"], $_POST["username"])) {
    //             // Check if user is in database
    //             $res =  $this->db->query("select * from users where email = $1;", $_POST["email"]);
    //             if (empty($res)) {
    //                 // User was not there, so insert them
    //                  $this->db->query("insert into users (username, email, password, last_login) values ($1, $2, $3, $4);",
    //                     $_POST["username"], $_POST["email"],
    //                     password_hash($_POST["password"], PASSWORD_DEFAULT), date("Y-m-d H:i:s"));
    //                 $_SESSION["username"] = $_POST["username"];
    //                 $_SESSION["email"] = $_POST["email"];
    //                 $_SESSION["last_login"] = date("Y-m-d H:i:s");
    //                 // Send user to the appropriate page (home)
    //                 // header("Location: ?command");
    //                 include("home.php");
    //                 return;
    //             } else {
    //                 // User was in the database, verify password
    //                 if (password_verify($_POST["password"], $res[0]["password"])) {
    //                     // Password was correct
    //                     $_SESSION["username"] = $res[0]["username"];
    //                     $_SESSION["email"] = $res[0]["email"];
    //                     $_SESSION["last_login"] = $res[0]["last_login"];
    //                     include("home.php");
    //                     return;
    //                 } else {
    //                     $message .= "<p class='alert alert-danger'> Incorrect Passwor. </p>";
    //                     include("login.php");
    //                     return;
    //                 }
    //             }
    //         }
    //     } else {
    //         $message .= "<p class='alert alert-danger'> All fields are required. </p>";
    //         include("login.php");
    //         return;
    //     }
    //     // If something went wrong, show the welcome page again
    //     $message .= "<p class='alert alert-danger'> Something went wrong. Please try again. </p>";
    //     include("login.php");
    //     return;
    // }

    // /**
    //  * Log out the user
    //  */
    //  public function logout() {
    //     // $this->db->query("update users set score = $1 where email = $2;", $_SESSION["score"], $_SESSION["email"]);
    //     session_destroy();
    //     session_start();
    // }

    public function submitItem()
    {
        if (
            !isset($_POST['itemName'], $_POST['itemDate'], $_POST['itemLocation'], $_POST['itemDescription']) ||
            empty($_POST['itemName']) ||
            empty($_POST['itemDate']) ||
            empty($_POST['itemLocation']) ||
            empty($_POST['itemDescription'])
        ) {
            echo "<script>alert('All fields are required.')</script>";
            include_once("makeRequest.html");
            return;
        }

        $itemName = $_POST['itemName'];
        $itemDate = $_POST['itemDate'];
        $itemLocation = $_POST['itemLocation'];
        $itemDescription = $_POST['itemDescription'];
        $itemImage = $_POST['itemImage'];

        // Check if date is in the future
        $currentDate = date("Y-m-d");
        if ($itemDate > $currentDate) {
            echo "<script>alert('Date cannot be in future.')</script>";
            include_once("makeRequest.html");
            return;
        }

        if (isset($_FILES['itemImage'])) {
            $uploadDirectory = "uploads/";
            $targetFile = $uploadDirectory . basename($_FILES['itemImage']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES['itemImage']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $this->errorMessage = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                $this->errorMessage = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['itemImage']['size'] > 500000) { // 500KB limit
                $this->errorMessage = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $this->errorMessage = "Sorry, only JPG, JPEG, and PNG files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $this->errorMessage = "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetFile)) {
                    echo "The file " . basename($_FILES['itemImage']['name']) . " has been uploaded.";
                    $itemImage = "temp/path/does/not/exist"; // Set the path to the successfully uploaded image.
                } else {
                    $this->errorMessage = "Sorry, there was an error uploading your file.";
                }
            }
        }
        // Sanitize the input data
        $itemName = pg_escape_string($itemName);
        $itemDate = pg_escape_string($itemDate);
        $itemLocation = pg_escape_string($itemLocation);
        $itemDescription = pg_escape_string($itemDescription);
        // $itemImage = "temp/path/does/not/exist";

        $res = $this->db->query(
            "INSERT INTO items (item_name, date_added, location_found, description, image) VALUES ($1, $2, $3, $4, $5)",
            $itemName,
            $itemDate,
            $itemLocation,
            $itemDescription,
            $itemImage
        );

        header("Location: lostItemsPage.php");



    }
}