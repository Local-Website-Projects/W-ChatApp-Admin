<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000/");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
$today = date("Y-m-d");


$fetch_user_details = $db_handle->runQuery("SELECT * FROM `users` WHERE `user_id` = {$_SESSION['user']}");
if($fetch_user_details){
    echo json_encode([
        "status" => "Success",
        "message" => "Fetch User Successful!",
        "user_name" => $fetch_user_details[0]['name'],
        "user_type" => $fetch_user_details[0]['type'],
    ]);
    exit;
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Something went wrong!",
    ]);
    exit;
}