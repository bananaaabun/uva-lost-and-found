<?php

// Grab all corresponding posted items for that user from our API as JSON
$user_items = json_decode(
    file_get_contents("http://localhost:8080/uva-lost-and-found/api/accountitems.php"), true); // TODO: MODIFY TO SERVER

?>

<section class="">
    <h4> Current Items </h4>

    <?php if(!empty($user_items)) { ?>

    <div class="lostItems d-flex flex-wrap justify-content-between">

        <a href="singleItemPage.html" style="color: black;">
            <div class="lost-item">Item 1 (image/details)</div>
        </a>
        <div class="lost-item">Item 2 (image/details)</div>
        
    </div>
    <a class="button-two" href="makeRequest.html">Add another item you have found or lost.</a>

    <?php } else { ?>

        <p> You have no current items. </p>
        <a class="button-two" href="makeRequest.html">Add an item you have found or lost.</a>

    <?php } ?>

</section>