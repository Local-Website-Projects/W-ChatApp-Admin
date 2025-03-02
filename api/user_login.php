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

function generateToken($userId) {
    return base64_encode("user_".$userId."_token");
}

$email = $db_handle->checkValue($_POST['email']);
$password = $db_handle->checkValue($_POST['password']);

$fetch_user = $db_handle->runQuery("SELECT * FROM `users` WHERE `email` = '$email' and status = 1");
$fetch_user_no = $db_handle->numRows("SELECT * FROM `users` WHERE `email` = '$email' and status = 1");

if($fetch_user_no > 0){
    $hashed_password = $fetch_user[0]['password'];
    if(password_verify($password, $hashed_password)){
        $_SESSION['user'] = $fetch_user[0]['user_id'];
        echo json_encode([
            "status" => "Success",
            "message" => "Login Successful!",
            "token" => generateToken($fetch_user[0]['user_id']),
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Userid or password is incorrect!"
        ]);
        exit;
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "This email is not registered or your account is not active yet!"
    ]);
    exit;
}

