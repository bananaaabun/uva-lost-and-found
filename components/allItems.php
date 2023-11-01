<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>UVA Lost and Found - Lost Items</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Barna Alimu and Nate Gleberman">
    <meta name="description" content="Page detailing a lost item">
    <meta name="keywords" content="lost and found portal">
</head>
<body>
    <?php include("components/navbar.php"); ?>

    <!-- containers for lost items -->
    <div class="container mt-5">
        <div style="padding-left: 20px;">
            <div style="display: flex; align-items: center;">
                <h1 style="margin-right: 50px;">Lost Items</h1>
            <div class="searchBar" style="margin-left: 50px;">
                <input type="text" class="form-control" placeholder="Search for items...">
            </div>
            </div>
        </div>
        <hr>
        <div class="lostItems d-flex flex-wrap justify-content-between">

        <?php 
            // Print out each item as a lost/found cell
            for($i = 0; $i < sizeof($all_items); $i += 1) {
                $cur_item = $all_items[$i];
                // print_r($cur_item);
                $img_src = "uploads/" . $cur_item["image_file_name"];
                $item_id = $cur_item["item_id"];
                // echo $img_src;
                echo "  
                        <a href=\"?command=itemPage-{$item_id}\" style=\"color: black;\">
                            <div class=\"lost-item\">{$cur_item["item_name"]}
                                <img src=\"{$img_src}\" style=\"width:100px;\" >
                            </div>
                        </a>
                     ";
            }

        ?>
        </div>
    </div>
    
    <!-- footer -->
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