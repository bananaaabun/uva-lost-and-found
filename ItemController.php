<?php

include_once "data-and-classes/Database.php";

class ItemController
{

    private $input = [];

    private $db;

    /**
     * Constructor
     */
    public function __construct($input)
    {

        session_start();

        $this->db = new Database();

        $this->input = $input;
    }

    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run()
    {
        // Get the command
        $command = "";
        if (isset($this->input["command"]))
            $command = $this->input["command"];
        switch ($command) {
            // Use regex to check if command starts with this. Split on dash. Thing after dash it item id.
            case preg_match('/itemPage-(\d+)/', $command, $matches) ? $command : !$command:
                $item_id = $matches[1];
                $this->showItemById($item_id);
                break;
            case preg_match('/getChat-(\d+)/', $command, $matches) ? $command : !$command:
                $item_id = $matches[1];
                $this->getChat($item_id);
                break;
            case preg_match('/addChat-(\d+)/', $command, $matches) ? $command : !$command:
                $item_id = $matches[1];
                $this->addChat($item_id);
                break;
            case preg_match('/getStatus-(\d+)/', $command, $matches) ? $command : !$command:
                $item_id = $matches[1];
                $this->getStatus($item_id);
                break;
            case preg_match('/toggleStatus-(\d+)/', $command, $matches) ? $command : !$command:
                $item_id = $matches[1];
                $this->toggleStatus($item_id);
                break;
            default:
                $this->displayAllItems();
                break;
        }

    }

    public function displayAllItems()
    {
        $all_items = $this->db->query("select * from items;");
        include("components/allItems.php");
        exit;
    }

    public function showItemById($item_id)
    {
        //not done 
        $item = $this->db->query("select * from items where item_id = $1", $item_id);
        if ($item && count($item) > 0) {
            $item = $item[0];
            include("singleItemPage.php");
        } else {
            echo "No item found with id $item_id";
        }
        exit;
    }

    public function getChat($item_id) {
        // Return JSON record of chats
        $chats = $this->db->query("select * from chats where item_id = $1;", $item_id);
        if (!isset($chats[0])) {
            die("No chats in the database");
        }
        header("Content-type: application/json");
        echo json_encode($chats, JSON_PRETTY_PRINT);
        exit;
    }

    public function addChat($item_id) {
        // Add chatline passed in from POST to database, return updated chat.
        if(!empty($_POST["chat"]) && !empty($_SESSION["username"])) {
            // If logged in and correct submission allow insert.
            $this->db->query("insert into chats (item_id, 
                message, date_sent, sender) values ($1, $2, $3, $4);", 
                $item_id, $_POST["chat"], date("Y-m-d H:i:s"), $_SESSION["username"]
            );
        }
    }

    public function getStatus($item_id) {
        $cur_status = $this->db->query("select claim_status from items where item_id = $1;", $item_id);
        header("Content-type: application/json");
        echo json_encode($cur_status, JSON_PRETTY_PRINT);
        exit;
    }

    public function toggleStatus($item_id) {
        if ($_SESSION["email"]) {
            $id_res = $this->db->query("select user_id from users where email = $1;", $_SESSION["email"]);
            $user_id = $id_res[0]["user_id"];
            $res = $this->db->query("select claim_status from items where item_id = $1;", $item_id);
            $claim_status = $res[0]["claim_status"];
            if ($claim_status === "claimed") {
                $new = "unclaimed";
            }
            else {
                $new = "claimed";
            }
            // Only let original poster change status
            $this->db->query("update items set claim_status = $1 where item_id = $2 and user_id = $3;", $new , $item_id, $user_id);
        }
    }

}

?>