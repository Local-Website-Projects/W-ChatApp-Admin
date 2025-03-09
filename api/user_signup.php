<?php
header("Access-Control-Allow-Origin: http://localhost:3000/");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
        $get_unique_id = $db_handle->runQuery("select user_id from users order by user_id desc limit 1");
        $verification_code = 'https://chat.dotest.click/verify/index.php?id=' . $get_unique_id[0]['user_id'];


        $subject = "Verify your email";
        $messege = "<html>
<body style='background-color: #eee; font-size: 16px;'>
<div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>

    <p style='text-align: center;color:#29a9e1;font-weight:bold'>Thank you for registering your account.</p>

    <p style='color:black;text-align: center'>
        Please visit <a href=$verification_code><strong>this link</strong></a> to verify your email.
    </p>
    <div style='font-size: 14px;'>
        <p style='margin-top: 30px;'>Sincerely,</p>
        <img src='' alt='logo' style='width: 200px; height:auto'/>
    </div>

</div>

</body>
</html>";

        $sender_name = "Chat App Demo";


        $sender_email = "chatapi@dotest.click";
        $username = "chatapi@dotest.click";
        $password = "EI:UClx5:Q";

        $receiver_email = $email;



        $mail = new PHPMailer(true);
        $mail->isSMTP();


        $mail->Host = "smtp.hostinger.com";


        $mail->SMTPAuth = true;


        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;


        $mail->setFrom($sender_email, $sender_name);
        $mail->Username = $username;
        $mail->Password = $password;

        $mail->CharSet = 'UTF-8';

        $mail->Subject = $subject;
        $mail->msgHTML($messege);
        $mail->addAddress($receiver_email);

        if ($mail->send()) {
            echo json_encode([
                "status" => "Success",
                "message" => "Email Send Successfully!"
            ]);
            exit;
        }else{
            echo json_encode([
                "status" => "error",
                "message" => "Email is not send."
            ]);
            exit;
        }
    } else {
        echo "Sorry! Something went wrong. Please try again later.";
    }
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Email is already registered"
    ]);
    exit;
}