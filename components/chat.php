

<!-- chat content -->

<?php

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include_once("../data-and-classes/Database.php");

    $item_id = $_GET['item_id'];

    echo $item_id;

    $db = new Database();
        
    $chats = $db->query("select * from chats where item_id = $1;", $item_id);

    for($i = 0; $i < sizeof($chats); $i += 1) {
        $cur_chat = $chats[0];
        $chat = $cur_chat["chat"];
        $sender = $this->db->query("select username from users where user_id = $1;", $cur_chat["sender_id"]);
        echo    `
                    <p><strong>$sender</strong>$chat</p>
                `;
    }

    echo "Test";

?>

        
    
