<?php

include_once "data-and-classes/Database.php";

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
    public function run()
    {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch ($command) {
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
        header("Location: makeRequest.php");
    }

    public function showLostItemsPage()
    {
        $items = $this->getLostItems();
        $message = "";
        if (!empty($this->errorMessage))
            $message .= "<p class='alert alert-danger'>" . $this->errorMessage . "</p>";
        // header("Location: lostItemsPage.php");
        // include_once("lostItemsPage.php");
        include("lostItemsPage.php");
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
        $itemImage = null;

        // Check if date is in the future
        $currentDate = date("Y-m-d");
        if ($itemDate > $currentDate) {
            echo "<script>alert('Date cannot be in future.')</script>";
            include_once("makeRequest.php");
            return;
        }

        if (isset($_FILES['itemImage'])) {
            $uploadDirectory = "uploads/";
            $targetFile = $uploadDirectory . basename($_FILES['itemImage']['name']);
            $uploadOk = true;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            // Check if file already exists
            if (file_exists($targetFile)) {
                $this->errorMessage = "Sorry, file already exists.";
                $uploadOk = false;
            }
            // Check file sizeif (!empty($_FILES['itemImage']['tmp_name'])) {
            $check = getimagesize($_FILES['itemImage']['tmp_name']);
            if ($check !== false) {
                $uploadOk = true;
            }

            if ($_FILES['itemImage']['size'] > 500000) { // 500KB limit
                $this->errorMessage = "Sorry, your file is too large.";
                $uploadOk = false;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $this->errorMessage = "Sorry, only JPG, JPEG, and PNG files are allowed.";
                $uploadOk = false;
            }
            // Check if $uploadOk is false if not set to target file
            if ($uploadOk && move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetFile)) {
                $itemImage = $targetFile; // Set to the path where the file is moved
            } else {
                $uploadOk = false;
            }
        }
        if (!empty($this->errorMessage)) {
            echo "<script>alert('" . $this->errorMessage . "')</script>";
        }

        if ($uploadOk && empty($this->errorMessage)) {

            $res = $this->db->query(
                "INSERT INTO items (item_name, date_added, location_found, description, image) VALUES ($1, $2, $3, $4, $5)",
                $itemName,
                $itemDate,
                $itemLocation,
                $itemDescription,
                $targetFile
            );

            if ($res === false) {
                $this->errorMessage = "Error submitting item.";
                include_once("makeRequest.php");
                return;
            } else {
                echo "<script>alert('Item submitted successfully.')</script>";
            }

        }

    }
    public function getLostItems()
    {
        $query = "SELECT * FROM items";
        try {
            $items = $this->db->query($query);
        } catch (Exception $e) {
            echo "Error querying the database.";
            exit;
        }
        return $items;
    }
}
