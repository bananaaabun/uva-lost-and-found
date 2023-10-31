<!-- https://cs4640.cs.virginia.edu/njg7hy/lost-and-found/ -->

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start(); 

$message = "";
if(!empty($_SESSION["message"]))
    $message = $_SESSION["message"];

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
         <title>UVA Lost and Found - Home</title>
         <link rel="stylesheet" type="text/css" href="styles/main.css" >
    </head>  
    <body>
        <?=$message?>
        <?php include("components/navbar.php"); ?>

        <main class="fc center gap">
            <section id="about" class="fr center">
                <img class="img-large" src="assets/rotunda-orange.png" alt="rotunda">
                <div class="img-large fc gap-small">
                    <h2>About Lost & Found</h2>
                    <p>The portal seeks to bridge the UVA community gaps by linking individuals who have misplaced items with those who've located them. Through a digital platform, members can swiftly report, search, and communicate regarding these items.</p>
                    <a class="button-one" href="lostItemsPage.html">I've lost something!</a>
                    <a class="button-two" href="makeRequest.html">I've found something!</a>
                </div>
            </section>
        </main>

        <?php include("components/footer.php"); ?>
    </body>
 </html>