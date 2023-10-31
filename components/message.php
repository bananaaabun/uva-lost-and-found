<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

if(!empty($_SESSION["message"])) { 
    $message = $_SESSION["message"];

    if($_SESSION["condition"] == "bad") {
    ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <!-- <strong>Holy guacamole!</strong> You should check in on some of those fields below. -->
        <?=$message?>
        <form action="reset.php" method="post" >
            <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </form>
        </div>

    <?php } else if ($_SESSION["condition"] == "good") { ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <!-- <strong>Holy guacamole!</strong> You should check in on some of those fields below. -->
        <?=$message?>
        <form action="reset.php" method="post" >
            <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </form>
        </div>

    <?php } else { ?>

        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <!-- <strong>Holy guacamole!</strong> You should check in on some of those fields below. -->
        <?=$message?>
        <form action="reset.php" method="post" >
            <button type="submit" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </form>
        </div>

    <?php } ?>

<?php } ?>

