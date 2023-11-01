<?php

include_once "data-and-classes/Database.php";

class ItemController {

    private $input = [];

    private  $db;

    /**
     * Constructor
     */
    public function __construct($input) {

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
    public function run() {
        // Get the command
        $command = "";
        if (isset($this->input["command"]))
            $command = $this->input["command"];
        
        switch($command) {
            case "showitem": // Use regex to check if command starts with this. Split on dash. Thing after dash it item id.
                $this->displayItem($item_id);
            default:
                $this->displayAllItems();
                break;
        }

    }

    public function displayAllItems() {
        $all_items = $this->db->query("select * from items;");
        include("components/allItems.php");
        exit;
    }

}