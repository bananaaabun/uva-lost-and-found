<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

?>

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
                <p id="itemId">
                    <?= $item["item_id"] ?>
                </p>
                <button type="button" style="opacity: 90%;" class="btn btn-danger">Not Claimed</button>
                <!-- Change to green if claimed and pull status from db-->
            </div>
            <!-- Chat container -->
            <div class="chatContainer mt-2">
                <div class="chatHeader text-white p-2 rounded-top">
                    Chat about this item
                </div>

                <!-- chat content -->
                <div id="chatBody" class="chatBody p-3" style="height: 200px; overflow-y: scroll; border: 1px solid #dcdcdc; background-color: #f5f5f5;">
                
                </div>

                <!-- send new chat -->
                <div id="chatForm" class="chatFooter p-2 bg-light rounded-bottom">
                    <input id="chatBox" type="text" class="form-control" placeholder="Type your message...">
                    <button id="chatButton" class="button-primary" style="margin-left: 5px;">Send</button>
                </div>

                <script>

                    let idContainer = document.getElementById("itemId");
                    let chatButton = document.getElementById("chatButton");
                    let itemId = idContainer.innerHTML.replace(/\s/g, "");
                    var chats;

                    // $("#chatBody").load("components/chat.php?getChat=" + itemId);

                    function loadChat() {
                        console.log("loading chats");
                        // $.get("?command=getChat-"+itemId, function(data) {
                        //     chats = data;
                        //     displayChats();
                        // });

                        var ajax = new XMLHttpRequest();
                        ajax.open("GET", "?command=getChat-"+itemId, true);
                        ajax.responseType = "json";
                        ajax.send(null);

                        ajax.addEventListener("load", function() {
                            // display the question
                            if (this.status == 200) {
                                chats = this.response;
                                displayChats(chats);
                            } else {
                                // Error message
                                console.log("error");
                            }
                        });
                    }

                    function displayChats(c) {
                        console.log("Displaying chats.");
                        let chatBody = document.getElementById("chatBody");
                        chatBody.innerHTML = "";
                        // if (!c)
                        //     console.log('here');
                        //     chatBody.innerHTML = "Start chatting now!";
                        //     return;
                        c.forEach(chat => {
                            console.log(chat);
                            let p = document.createElement("p");
                            p.innerHTML = `<strong>${chat["sender_id"]}</strong> ${chat["message"]}`;
                            chatBody.appendChild(p);
                        })
                    }

                    function sendChat(itemId) {
                        let chatBox = document.getElementById("chatBox");
                        let chatValue = chatBox.value;
                        console.log("Sending chat - " + chatValue);
                        if (!chatValue)
                            return
                        $.post("?command=addChat-" + itemId,
                            {
                                chat: chatValue,
                            },
                            function() {
                                loadChat();
                            }
                        )
                    }

                    chatButton.addEventListener("click", (event) => {
                        console.log("clicked");
                        sendChat(itemId);
                    });

                    loadChat();

                </script>

            </div>
        </div>
    </section>
    <?php include("components/footer.php"); ?>
</body>

</html>
