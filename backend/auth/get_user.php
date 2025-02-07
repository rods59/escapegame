<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Utilisateur non connecté."]);
    exit;
}

echo json_encode(["success" => true, "username" => $_SESSION["username"]]);
?>
