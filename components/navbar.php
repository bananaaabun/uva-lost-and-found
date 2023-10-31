<nav id="primary-nav" class="fr">
    <a href="home.php" class="fr" style="color: black; text-decoration: none;">
        <img src="assets/logo.png" class="logo" alt="logo">
        <h2>Lost & Found at UVA</h2>
    </a>
    <ul class="nav-list fr" style="height: 35px;">
        <li><a href="makeRequest.php">Make a Request</a></li>
        <li><a href="lostItemsPage.php">Lost Items</a></li>
        <li>
            <a href="login.php" class="account-button center" style="padding: 20px;">
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
    <a href="makeRequest.php" class="ap">Make a Request</a>
    <a href="lostItemsPage.php" class="ap">Lost Items</a>
    <a href="login.php" class="ap">Account</a>
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
