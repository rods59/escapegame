<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    echo json_encode(["success" => false, "message" => "Données incomplètes."]);
    exit;
}

$email = trim($data->email);
$password = $data->password;

$stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        error_log("Connexion réussie pour l'utilisateur: " . $_SESSION["username"]);

        echo json_encode(["success" => true, "message" => "Connexion réussie !", "username" => $_SESSION["username"]]);
    } else {
        error_log("Mot de passe incorrect pour : $email");
        echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect."]);
    }
} else {
    error_log("Utilisateur non trouvé : $email");
    echo json_encode(["success" => false, "message" => "Email ou mot de passe incorrect."]);
}
?>
