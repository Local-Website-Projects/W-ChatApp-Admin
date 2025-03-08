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

$fetch_user = $db_handle->runQuery("SELECT * FROM users WHERE user_id = {$_SESSION['user']}");

echo json_encode([
    "status" => "Success",
    "userId" => $fetch_user[0]['user_id'],
    "userName" => $fetch_user[0]['name'],
]);

exit;