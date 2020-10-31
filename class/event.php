<?php

require_once "connection/connection.php";
require_once "response.php";

class event extends connection {

    private $table = "events";

    public function listEvents() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

}

?>