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
    <title>UVA Lost and Found - Single Item</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Barna Alimu and Nate Gleberman">
    <meta name="description" content="Page detailing a lost item">
    <meta name="keywords" content="lost and found portal">
</head>
<body>
<?php include("components/navbar.php"); ?>
<section class="fr" style="align-items: flex-start;">
    <div id="left" class="fc outline" style="margin-top: 0px">
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
            <p id="itemId" style="display:none;">
                <?= $item["item_id"] ?>
            </p>
            <button type="button" id="statusButton" style="opacity: 90%;" class="btn btn-danger" >Not Claimed</button>
        </div>
        <div class="imgContainer">
            <div id="itemCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?php 
                            $img_src = "uploads/" . $item["image_file_name"];
                            echo "<img src=\"{$img_src}\" alt=\"LostItem\">";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="right" class="fc">
        <div class="chatContainer" >
            <div class="chatHeader text-white p-2 rounded-top">
                Item Forum
            </div>

            <!-- chat content -->
            <div id="chatBody" class="chatBody p-3" style="height: 100%; min-height: 500px; overflow-y: scroll; border: 1px solid #dcdcdc; background-color: #f5f5f5;">
            
            </div>

            <!-- send new chat -->
            <form id="chatForm" class="chatFooter p-2 bg-light rounded-bottom">
                <input id="chatBox" type="text" class="form-control" placeholder="Type your message...">
                <button id="chatButton" class="button-primary" style="margin-left: 5px;">Send</button>
            </form>

            <script>

                // Handle the chat

                let idContainer = document.getElementById("itemId");
                let chatForm = document.getElementById("chatForm");
                let itemId = idContainer.innerHTML.replace(/\s/g, "");
                var chats;

                function loadChat() {
                    var ajax = new XMLHttpRequest();
                    ajax.open("GET", "?command=getChat-"+itemId, true);
                    ajax.responseType = "json";
                    ajax.send(null);

                    ajax.addEventListener("load", function() {
                        if (this.status == 200) {
                            chats = this.response;
                            displayChats(chats);
                        } else {
                            console.log("error");
                        }
                    });
                }

                function displayChats(c) {
                    let chatBody = document.getElementById("chatBody");
                    chatBody.innerHTML = "";
                    if (c) {
                        c.forEach(chat => {
                            let p = document.createElement("p");
                            p.innerHTML = `<strong>${chat["sender"]}</strong>: ${chat["message"]} - <small>${chat["date_sent"]}</small>`;
                            chatBody.appendChild(p);
                        })
                        chatBody.scrollTo(0, chatBody.scrollHeight);
                    }
                    else {
                        chatBody.innerHTML = "Start chatting!"
                    }
                }

                function sendChat(itemId) {
                    let chatBox = document.getElementById("chatBox");
                    let chatValue = chatBox.value;
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

                chatForm.addEventListener("submit", (event) => {
                    event.preventDefault();
                    let chatTextbox = document.getElementById("chatBox");
                    sendChat(itemId);
                    chatTextbox.value = "";
                })

                loadChat(); // Do this on page load anyways

                // Handle the status button
                let statusButton = document.getElementById("statusButton");

                function displayStatus(object) {
                    // console.log(object);
                    if (object[0]["claim_status"] == "claimed") {
                        statusButton.classList.remove("btn-danger");
                        statusButton.classList.add("btn-success");
                        statusButton.innerHTML = "Claimed!";
                    }
                    else {
                        statusButton.classList.remove("btn-success");
                        statusButton.classList.add("btn-danger");
                        statusButton.innerHTML = "Not claimed!";
                    }
                }

                function getStatus() {
                    var ajax = new XMLHttpRequest();
                    ajax.open("GET", "?command=getStatus-"+itemId, true);
                    ajax.responseType = "json";
                    ajax.send(null);

                    ajax.addEventListener("load", function() {
                        if (this.status == 200) {
                            let jsonResponse = this.response;
                            displayStatus(jsonResponse);
                        } else {
                            console.log("error");
                        }
                    });
                }

                function updateStatus() {
                    $.post("?command=toggleStatus-" + itemId,
                        function() {
                            getStatus();
                        }
                    )
                }

                getStatus();

                statusButton.addEventListener("click", (event) => {
                    updateStatus();
                })

            </script>
            <div class="outline" style="margin: 25px 0px 0px 0px;">
                <p><strong>Guide: </strong>If this is your item, please connect with the poster in the forum. If you are the poster and this item has been claimed, please click the button below to toggle.</p>
                <strong>The item can be deleted from original poster's account page.</strong>
            </div>   
        </div>
    </div>
</section>
<?php include("components/footer.php"); ?>
</body>
</html>
