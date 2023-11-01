<div class="fc center outline grow">
    <h2>Account</h2>
    <img src="assets/logo.png" style="width: 200px;" alt="logo">
</div>

<?php include("modAccountForm.php"); 

// print_r($_SESSION["user_items"]);
?>

<section id="about" class="fc center outline">
    <h4> Current Items </h4>

    <?php if(!empty($_SESSION["user_items"])) { 

        $itemCount = sizeof($_SESSION["user_items"]);

        echo "You have {$itemCount} item(s)";

    } else { ?>

        <p> You have no items currently. </p>
        <a class="button-one" href="makeRequest.html">Add an item you have found or lost.</a>

    <?php } ?>

</section>