<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
     <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1"> 
         <meta name="author" content="Barna Alimu and Nate Gleberman">
         <meta name="description" content="Lost and Found Portal">
         <meta name="keywords" content="UVA lost found Charlottesville"> 
         <title>UVA Lost and Found - Make a Request</title>
         <link rel="stylesheet" type="text/css" href="styles/main.css" >
    </head>  
    <body>
        <?=$message?>
        <?php include("components/navbar.php"); ?>

        <div class="container">
            <div class="submission-form">
                <h2>Found an Item?</h2>
                <hr>
                <form method="POST" onsubmit="return showFormData(event)">
                    <div class="form-group">
                        <label for="itemName">Item Name:</label>
                        <input type="text" id="itemName" name="itemName" placeholder="e.g., Earring">
                    </div>
                    <div class="form-group">
                        <label for="itemDate">Date Found:</label>
                        <input type="date" id="itemDate" name="itemDate">
                    </div>
                    <div class="form-group">
                        <label for="itemLocation">Location Found:</label>
                        <input type="text" id="itemLocation" name="itemLocation" placeholder="e.g., Newcomb Hall">
                    </div>
                    <div class="form-group">    
                        <label for="itemDescription">Description:</label>
                        <textarea id="itemDescription" name="itemDescription" rows="3" placeholder="Provide a brief description of the item"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="itemImage">Upload Image:</label>
                        <input type="file" id="itemImage" name="itemImage">
                    </div>
                    <button class="button-primary" type="submit">Submit Found Item</button>
                </form>
            </div>
        </div>
    
        <?php include("components/footer.php"); ?>
    </body>
</html>
 <!-- form submission post data logic testing only-->
<!-- <script>
    function showFormData(event) {
        const itemName = document.getElementById('itemName').value;
        const itemDate = document.getElementById('itemDate').value;
        const itemLocation = document.getElementById('itemLocation').value;
        const itemDescription = document.getElementById('itemDescription').value;

        const message = 
            "Item Name: " + itemName + "\n" +
            "Date Found: " + itemDate + "\n" +
            "Location Found: " + itemLocation + "\n" +
            "Description: " + itemDescription;

        alert(message);
        
        event.preventDefault(); // prevents page from reloading
        event.target.reset(); // clears form fields
        location.reload(); // reloads page
    }

</script> -->