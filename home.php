<!-- https://cs4640.cs.virginia.edu/njg7hy/lost-and-found/ -->

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
         <!-- Nav Bar -->
        <nav id="primary-nav" class="fr">
            <a href="index.html" class="fr" style="color: black; text-decoration: none;">
                <img src="assets/logo.png" class="logo" alt="logo">
                <h2>Lost & Found at UVA</h2>
            </a>
            <ul class="nav-list fr" style="height: 35px;">
                <li><a href="makeRequest.html">Make a Request</a></li>
                <li><a href="lostItemsPage.html">Lost Items</a></li>
                <li>
                    <a href="?command=showlogin" class="account-button center" style="padding: 20px;">
                        <?php 
                            if(!empty($_SESSION["username"])) {
                                echo $_SESSION["username"];
                            }
                            else {
                                echo "<img src=\"assets/profile-circle.svg\" alt=\"profilePic\" style=\"margin-right: 15px;\"> Log in";
                            }
                        ?>
                    </a>
                </li>
            </ul>
            <button onclick="openMenu()" id="nav-button">Menu</button>
        </nav>
        <div id="mobile-menu" class="fc">
            <button onclick="closeMenu()" id="close-button">&times;</button>
            <a href="makeRequest.html" class="ap">Make a Request</a>
            <a href="lostItemsPage.html" class="ap">Lost Items</a>
            <a href="login.html" class="ap">Account</a>
        </div>
        <script>
            let menu = document.getElementById("mobile-menu");
            function openMenu() {
                menu.style.display = "flex";
            }
            function closeMenu() {
                menu.style.display = "none";
            }
        </script>
        <div class="nav-line"></div>
    <!-- End of Nav Bar -->
    <?=$message?>

     <!-- main content -->
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
         
        <!-- Footer -->
        <footer class="fc center">
            <h1 style="margin-bottom: 45px;">Lost & Found</h1>
            <nav class="bottom-nav">
                <ul class="nav-list">
                    <li><a href="makeRequest.html">Found Something</a></li>
                    <li><a href="lostItemsPage.html">Lost Something</a></li>
                </ul>
            </nav>
        </footer>
    </body>
 </html>