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

    <section class="sectionContainer">
        <div class="imgContainer">
            <div id="itemCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/earrings.jpg" alt="Earrings">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/earrings.jpg" alt="Earrings2">
                    </div>
                    <!-- Add more carousel-item divs for more images as needed -->
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#itemCarousel" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-label="leftArrow"></span>
                </a>
                <a class="carousel-control-next" href="#itemCarousel" data-slide="next">
                    <span class="carousel-control-next-icon" aria-label="rightArrow"></span>
                </a>
            </div>
        </div>
        <div class="rightSideContainer">
            <div class="itemContainer">
                <h2>
                    <?= $item["item_name"] ?>
                </h2>
                <hr>
                <p><strong>Found on:</strong>
                    <?= $item["date_added"] ?>
                </p>
                <p><strong>Location:</strong>
                    <?= $item["location_found"] ?>
                </p>
                <p><strong>Description:</strong>
                    <?= $item["item_description"] ?>
                </p>
                <button type="button" style="opacity: 90%;" class="btn btn-danger">Not Claimed</button>
                <!-- Change to green if claimed and pull status from db-->
            </div>
            <!-- Chat container -->
            <?php include("components/chat.php"); ?>
        </div>
    </section>
    <?php include("components/footer.php"); ?>
</body>

</html>