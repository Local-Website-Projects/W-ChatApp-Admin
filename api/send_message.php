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

$msg = $db_handle->checkValue($_POST['msg']);
$receiver = $db_handle->checkValue($_POST['receiver']);

$insert_msg = $db_handle->insertQuery("INSERT INTO `message_table`(`sender_id`, `receiver_id`, `message`, `inserted_at`) VALUES ({$_SESSION['user']},'$receiver','$msg','$inserted_at')");
if($insert_msg){
    echo json_encode([
        "status" => "Success",
        "message" => "Login Successful!",
    ]);
    exit;
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Message send failed!",
    ]);
    exit;
}