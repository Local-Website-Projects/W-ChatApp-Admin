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

$fetch_chats = $db_handle->runQuery("SELECT * FROM (SELECT m.*, u.name,ROW_NUMBER() OVER (PARTITION BY m.sender_id ORDER BY m.msg_id DESC) AS rn FROM message_table AS m JOIN users AS u ON m.sender_id = u.user_id WHERE m.receiver_id = {$_SESSION['user']}) AS latest_messages WHERE rn = 1 ORDER BY msg_id DESC");
$fetch_chats_no = $db_handle->numRows("SELECT * FROM (SELECT m.*, u.name,ROW_NUMBER() OVER (PARTITION BY m.sender_id ORDER BY m.msg_id DESC) AS rn FROM message_table AS m JOIN users AS u ON m.sender_id = u.user_id WHERE m.receiver_id = {$_SESSION['user']}) AS latest_messages WHERE rn = 1 ORDER BY msg_id DESC");

if ($fetch_chats_no > 0) {
    echo json_encode($fetch_chats);  // Return JSON response
} else {
    echo json_encode([]);
}
exit();