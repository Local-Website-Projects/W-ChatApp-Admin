<?php
header("Access-Control-Allow-Origin: http://localhost:3000/");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
$today = date("Y-m-d");

$email = $db_handle->checkValue($_POST['email']);
$name = $db_handle->checkValue($_POST['name']);
$phone = $db_handle->checkValue($_POST['phone']);
$password = $db_handle->checkValue($_POST['password']);
$marketplace = $db_handle->checkValue($_POST['marketplace']);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$fetch_user = $db_handle->numRows("SELECT * FROM `users` WHERE `email` = '$email'");

if($fetch_user == 0){
    $register_user = $db_handle->insertQuery("INSERT INTO `users`(`name`, `phone`, `email`, `marketplace`, `password`, `inserted_at`) VALUES ('$name','$phone','$email','$marketplace','$hashedPassword','$inserted_at')");

    if ($register_user) {
        echo json_encode([
            "status" => "Success",
            "message" => "Email Send Successfully!"
        ]);
        exit;
    }else{
        echo json_encode([
            "status" => "error",
            "message" => "Something went wrong!"
        ]);
        exit;
    }
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Email is already registered"
    ]);
    exit;
}