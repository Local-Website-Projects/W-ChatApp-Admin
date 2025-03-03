<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000/");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
$today = date("Y-m-d");

if(isset($_GET['receiverId'])){
    $receiver_id = $_GET['receiverId'];
    $message = "select * from message_table where (sender_id = '$receiver_id' and receiver_id = {$_SESSION['user']}) or (sender_id = {$_SESSION['user']} and receiver_id = '$receiver_id') ORDER by inserted_at ASC";
    $fetch_message = $db_handle->runQuery($message);
    $fetch_message_no = $db_handle->numRows($message);

    if($fetch_message_no > 0){
        echo json_encode($fetch_message);
    } else{
        echo json_encode([]);
    }
} else{
    echo json_encode([]);
}

