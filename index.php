<!-- https://cs4640.cs.virginia.edu/njg7hy/lost-and-found/ -->
<!-- 
    
sources:
    1. https://stackoverflow.com/questions/49199462/unset-is-triggering-too-early-and-cancelling-the-earlier-actions
        Help with an error on messages 
    2. https://www.w3schools.com/csS/css3_shadows_box.asp
        Cool shadow effects on boxes
    3. https://stackoverflow.com/questions/10800355/remove-whitespaces-inside-a-string-in-javascript
        Remove spaces from string
    
-->
<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

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
    <title>UVA Lost and Found - Home</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script>
        (function () {
            $(document).ready(function () {
                $("#about .button-one").hover(
                    function () { // Hover on
                        $(this).css({
                            "background-color": white,
                            "color": rgb(231, 115, 6)
                        });
                    },
                    function () { // Hover off
                        $(this).css({
                            "background-color": rgb(231, 115, 6),
                            "color": white
                        });
                    }
                );
            });
        })();
    </script>
</head>

<body>
    <?php include("components/navbar.php"); ?>

    <main class="fc center gap">
        <section id="about" class="fr center">
            <img class="img-large" src="assets/rotunda-orange.png" alt="rotunda">
            <div class="img-large fc gap-small">
                <h2>About Lost & Found</h2>
                <p>The portal seeks to bridge the UVA community gaps by linking individuals who have misplaced items
                    with those who've located them. Through a digital platform, members can swiftly report, search, and
                    communicate regarding these items.</p>
                <a class="button-one" href="lostItemsPage.php">I've lost something!</a>
                <a class="button-two" href="makeRequest.php">I've found something!</a>
            </div>
        </section>
    </main>

    <?php include("components/footer.php"); ?>

</body>

</html>