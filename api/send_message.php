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

$image = '';
if (!empty($_FILES['file']['name'])) {
    $RandomAccountNumber = mt_rand(1, 99999);
    $file_name = $RandomAccountNumber . "_" . $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp  = $_FILES['file']['tmp_name'];

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if ($file_type != "jpg" && $file_type != "png" && $file_type != "pdf") {
        $attach_files = '';
        echo "This file format is not accepted";
    }
    move_uploaded_file($file_tmp, "../files/" . $file_name);
    $image = "files/" . $file_name;
}
$insert_msg = $db_handle->insertQuery("INSERT INTO `message_table`(`sender_id`, `receiver_id`, `message`,`file`, `inserted_at`) VALUES ({$_SESSION['user']},'$receiver','$msg','$image','$inserted_at')");
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
