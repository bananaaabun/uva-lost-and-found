<div class="fc center outline grow">
    <h2>Account</h2>
    <img src="assets/logo.png" style="width: 200px;" alt="logo">
</div>

<?php include("modAccountForm.php"); ?>

<section id="about" class="fc center outline">
    <h4> Current Items </h4>

    <?php if(!empty($_SESSION["user_items"])) { ?>

        <div class="lostItems d-flex flex-wrap justify-content-between">

            <a href="singleItemPage.html" style="color: black;">
                <div class="lost-item">Item 1 (image/details)</div>
            </a>
            <div class="lost-item">Item 2 (image/details)</div>
            
        </div>
        <a class="button-two" href="makeRequest.html">Add another item you have found or lost.</a>

    <?php } else { ?>

        <p> You have no items currently. </p>
        <a class="button-one" href="makeRequest.html">Add an item you have found or lost.</a>

    <?php } ?>

</section>