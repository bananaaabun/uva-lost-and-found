<?php

include_once "data-and-classes/Database.php";

class SubmissionController {

    private $input = [];

    private  $db;

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
            case "submit":
                $this->submit();
                break;
            default:
                break;
        }

    }

    /**
     * Handle user registration and log-in
     */
    public function submit() {

        // print_r($_FILES);
        // exit;

        $_SESSION["message"] = "";
        $_SESSION["condition"] = "";

        // print_r($_POST);
        // exit;

        if (empty($_SESSION["email"])) {
            // User must be logged in to submit an item
            $_SESSION["message"] = "Please login or register before submitting an item!";
            $_SESSION["condition"] = "bad";
            session_write_close();
            header("Location: login.php");
            exit;
        }

        include("helper/regex-checks.php");

        if (
            !isset($_POST['itemName'], $_POST['itemDate'], $_POST['itemLocation'], $_POST['itemDescription']) ||
            empty($_POST['itemName']) ||
            empty($_POST['itemDate']) ||
            empty($_POST['itemLocation']) ||
            empty($_POST['itemDescription'])
        ) {
            $_SESSION["message"] = "All fields are required.";
            $_SESSION["condition"] = "bad";
            session_write_close();
            header("Location: makeRequest.php");
            exit;
        }
        // user_id  int,
        $id_res = $this->db->query("select user_id from users where email = $1;", $_SESSION["email"]);
        $id = $id_res[0]["user_id"];
        // item_name  text,
        $itemName = $_POST['itemName'];
        // description   text,
        $itemDescription = $_POST['itemDescription'];
        // status boolean,
        $itemStatus = $_POST['status'];
        if($itemStatus === "false") {
            $itemStatus = false;
        }
        else {
            $itemStatus = true;
        }
        // date_added timestamp,
        $itemDate = $_POST['itemDate'];
        // location_found text,
        $itemLocation = $_POST['itemLocation'];
        // image text,
        // $itemImage = $_POST['itemImage'];
        $item_image_filename = basename($_FILES['itemImage']['name']);

        // Check if date is in the future
        $currentDate = date("Y-m-d");
        if ($itemDate > $currentDate) {
            $_SESSION["message"] = "Date cannot be in future.";
            $_SESSION["condition"] = "bad";
            session_write_close();
            header("Location: makeRequest.php");
            exit;
        }

        if (isset($_FILES['itemImage'])) {
            $uploadDirectory = "uploads/";
            $targetFile = $uploadDirectory . basename($_FILES['itemImage']['name']);
            $uploadOk = true;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES['itemImage']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                // $this->errorMessage = "File is not an image.";
                $_SESSION["message"] = "File is not an image.";
                $_SESSION["condition"] = "bad";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                $_SESSION["message"] = "Sorry, file already exists. Please try another name.";
                $_SESSION["condition"] = "bad";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['itemImage']['size'] > 500000) { // 500KB limit
                $_SESSION["message"] = "Sorry, your file is too large.";
                $_SESSION["condition"] = "bad";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION["message"] = "Sorry, only JPG, JPEG, and PNG files are allowed.";
                $_SESSION["condition"] = "bad";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                session_write_close();
                header("Location: makeRequest.php");
                exit;
            } else {
                if (move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetFile)) {
                    // echo "The file " . basename($_FILES['itemImage']['name']) . " has been uploaded.";
                    $_SESSION["message"] = "The file " . basename($_FILES['itemImage']['name']) . " has been uploaded.";
                    $_SESSION["condition"] = "good";
                    // $itemImage = "temp/path/does/not/exist"; // Set the path to the successfully uploaded image.
                } else {
                    // $this->errorMessage = "Sorry, there was an error uploading your file.";
                    $_SESSION["message"] = "Sorry, there was an error uploading your file. Please try a new file.";
                    $_SESSION["condition"] = "good";
                }
            }
        }

        $res = $this->db->query(
            "INSERT INTO items (user_id, item_name, date_added, location_found, item_description, image_file_name, lf_status) VALUES ($1, $2, $3, $4, $5, $6, $7)",
            $id,
            $itemName,
            $itemDate,
            $itemLocation,
            $itemDescription,
            $item_image_filename,
            $itemStatus
        );
        if (!$res) {
            // die("Query failed: " . pg_last_error() . "\n");
            $_SESSION["message"] = "Something went wrong. Please try again later.";
            $_SESSION["condition"] = "bad";
        }
        $_SESSION["message"] = "The file " . basename($_FILES['itemImage']['name']) . " has been uploaded and your item is now public.";
        $_SESSION["condition"] = "good";
        session_write_close();
        header("Location: lostItemsPage.php");
        exit;
    }

}