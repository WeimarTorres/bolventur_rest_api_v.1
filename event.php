<?php

require_once "class/response.php";
require_once "class/event.php";

$_response = new response;
$_event = new event;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $listTable = $_event->listEvents();
    header("Content-Type: application/json");
    echo json_encode($listTable);
    http_response_code(200);
} else {
    header('Content-Type: application/json');
    http_response_code(405);
    $data = $_response->error_405();
    echo json_encode($data);
}

?>