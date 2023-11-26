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

}