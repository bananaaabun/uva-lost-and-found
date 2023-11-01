<?php

// Grab all corresponding posted items for that user
$id_res = $this->db->query("select user_id from users where email = $1;", $_SESSION["email"]);
$id = $res[0]["user_id"];
$user_items = json_encode($this->db->query("select * from items where user_id = $1;", $id));

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