<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles/singleItems.css">
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
        <?=$message?>
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
                    <h2>Earring</h2>
                    <hr>
                    <p><strong>Found on:</strong> 10/10/2020</p>
                    <p><strong>Location:</strong> Newcomb Hall</p>
                    <p><strong>Description:</strong> Gold earring with a blue gem</p>
                    <button type="button" style="opacity: 90%;" class="btn btn-danger">Not Claimed</button>
                </div>
                <!-- Chat container -->
                <div class="chatContainer mt-2">
                    <div class="chatHeader text-white p-2 rounded-top">
                        Chat about this item
                    </div>
                    <div class="chatBody p-3" style="height: 200px; overflow-y: scroll; border: 1px solid #dcdcdc; background-color: #f5f5f5;">
                        <p><strong>User A:</strong> Did anyone claim this yet, I think this is mine?</p>
                        <p><strong>User B:</strong> No, I found it at newcomb</p>
                    </div>
                    <div class="chatFooter p-2 bg-light rounded-bottom">
                        <input type="text" class="form-control" placeholder="Type your message...">
                        <button class="button-primary" style="margin-left: 5px;">Send</button>
                    </div>            
                </div>
            </div>
        </section>
        <?php include("components/footer.php"); ?>
    </body>
</html>

    
    

    
    
    