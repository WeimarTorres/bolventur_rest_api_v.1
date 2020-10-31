<?php

require_once "class/response.php";
require_once "class/favoriteEvent.php";

$_response = new response;
$_favoriteEvent = new favoriteEvent;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["uid"])) {
        $eventId = $_GET['uid'];
        $dataEvent = $_favoriteEvent->listFavorites($eventId);
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($dataEvent);
        http_response_code(200);
    }else{
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        http_response_code(400);
        $data = $_response->error_400();
        echo json_encode($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    
    $dataArray = $_favoriteEvent->create($postBody);
    
    header("Access-Control-Allow-Origin: *");
    header('content-Type: application/json');
    if (isset($dataArray["result"]["error_id"])) {
        $responseCode = $dataArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $postBody = file_get_contents("php://input");

    $dataArray = $_favoriteEvent->update($postBody);

    header("Access-Control-Allow-Origin: *");
    header('content-Type: application/json');
    if (isset($dataArray['result']['error_id'])){
        $responseCode=$dataArray['result']['error_id'];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($dataArray);
} /*else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $postBody = file_get_contents("php://input");
    $dataArray = $_favoriteEvent->delete($postBody);

    header('content-type: application/json');
    if (isset($dataArray['result']['error_id'])) {
        $responseCode = $dataArray['result']['error_id'];
        http_response_code($responseCode);
    } else {
        return http_response_code(200);
    }
    echo json_encode($dataArray);
} */else {
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    http_response_code(405);
    $data = $_response->error_405();
    echo json_encode($data);
}

?>