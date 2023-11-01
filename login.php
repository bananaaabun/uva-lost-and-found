<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// spl_autoload_register(function ($classname) {
//     include "data-and-classes/$classname.php";
// });

include_once "SessionController.php";

$session_controller = new SessionController($_GET);

$session_controller->run();

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
         <meta name="keywords" content="UVA lost found Charlottesville login login-page"> 
         <title>UVA Lost and Found - Login</title>
         <link rel="stylesheet" type="text/css" href="styles/main.css" >
    </head>  
    <body>
        <?php include("components/navbar.php"); ?>

         <!-- log in block -->
        <main class="fc center gap">

                <?php   
                
                    if(empty($_SESSION["username"])) {

                        echo "<section class=\"fr stretch\">";

                        include("components/loginform.php");
                    
                    } else { 

                        echo "<h1> {$_SESSION["username"]} </h1><section class=\"fr stretch\">";
                        
                        include("components/account.php");

                    }
                ?>             

            </section>
        </main>
        
         <?php include("components/footer.php"); ?>
    </body>
 </html>