<?php

include_once "data-and-classes/Database.php";

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
    public function showHome() {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>".$this->errorMessage."</p>";
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
        header("Location: makeRequest.php");
    }

    public function showLostItemsPage()
    {
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>" . $this->errorMessage . "</p>";
        header("Location: lostItemsPage.php");
    }

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
            include_once("makeRequest.php");
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
            $uploadOk = true;
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
            //if no error message show success message pop up
            if(empty($this->errorMessage)){
                echo "<script>alert('Item successfully submitted.')</script>";

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