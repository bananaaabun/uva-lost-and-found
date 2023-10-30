<?php
/*for handling files: https://www.php.net/manual/en/features.file-upload.php, 
    https://www.php.net/manual/en/reserved.variables.files.php */
include 'db_setup.php';

$itemName = $_POST['itemName'];
$itemDate = $_POST['itemDate'];
$itemLocation = $_POST['itemLocation'];
$itemDescription = $_POST['itemDescription'];
$itemImage = $_POST['itemImage'];

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
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['itemImage']['size'] > 500000) { // 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['itemImage']['tmp_name'], $targetFile)) {
            echo "The file " . basename($_FILES['itemImage']['name']) . " has been uploaded.";
            $itemImage = $targetFile; // Set the path to the successfully uploaded image.
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$query = "INSERT INTO items (item_name, date_added, location_found, description, image) VALUES ($1, $2, $3, $4, $5)";
$result = pg_query_params($dbHandle, $query, array($itemName, $itemDate, $itemLocation, $itemDescription, $itemImage));

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
} else {
    echo("Item successfully added!");
}

header("Location: lostItemsPage.html");
exit;

?>