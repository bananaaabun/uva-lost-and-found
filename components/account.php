<div class="fc center outline grow">
    <h2>Account</h2>
    <img src="assets/logo.png" style="width: 200px;" alt="logo">
</div>

<script>
    function deleteItem(id) {
        console.log(id);
    }
</script>

<?php include("modAccountForm.php"); 

// print_r($_SESSION["user_items"]);
?>

<section id="about" class="fc center outline">
    <h4> Current Items </h4>

    <?php if(!empty($_SESSION["user_items"])) { 

        $itemCount = sizeof($_SESSION["user_items"]);

        echo "<p>You have {$itemCount} item(s)</p><br><div class=\"d-flex flex-row flex-wrap justify-content-center\">";

        for ($i = 0; $i < sizeof($_SESSION["user_items"]); $i += 1) {
            $cur_item = $_SESSION["user_items"][$i];
            $item_id = $cur_item["item_id"];
            $claim_status = $cur_item["claim_status"];
            echo "  
                <div class=\"fc center outline\">
                    <h4 class=\"item-name\" style=\"font-weight:bold;\">{$cur_item["item_name"]}</h4>
                    <p>Status: {$claim_status} </p>
                    <button class=\"btn btn-danger\">Delete Item</button>
                </div>
                ";
        }

        echo `</div>`;

    } else { ?>

        <p> You have no items currently. </p>
        <a class="button-one" href="makeRequest.html">Add an item you have found or lost.</a>

    <?php } ?>

</section>