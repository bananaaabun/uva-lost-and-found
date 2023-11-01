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
            <!-- Rendering the items fetched from the database -->
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <a href="singleItemPage.php?item_id=<?php echo $item['item_id']; ?>" style="color: black;">
                        <div class="lost-item">
                            <?php if ($item["image"] == null): ?>
                                <img src="./uploads/IMG_2174.png" alt="Item Image">
                            <?php else: ?>
                                <img src="./<?php echo $item["image"]; ?>" alt="Item Image">
                            <?php endif; ?>
                            <p>
                                <?php echo $item['item_name']; ?>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No lost items found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include("components/footer.php"); ?>
</body>