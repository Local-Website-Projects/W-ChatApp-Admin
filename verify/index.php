<?php
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
$today = date("Y-m-d");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $update_status = $db_handle->runQuery("UPDATE `users` SET `status`='[value-7]',`updated_at`='[value-10]' WHERE `user_id` = '$id'");
    if($update_status){
        echo "
        <script>
        alert('Your email has been confirmed! You can login to your account now.');
        window.close();
</script>
        ";
    } else {
        echo "
        <script>
        alert('Something went wrong. Please try again.');
        window.close();
</script>
        ";
    }
} else{
    echo "
        <script>
        alert('Something went wrong. Please try again.');
        window.close();
</script>
        ";
}