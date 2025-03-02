<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3000/");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

session_unset();
session_destroy();
echo json_encode([
    "success" => true,
    "message" => "User successfully logged out."
]);
