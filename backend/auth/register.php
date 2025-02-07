<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->username) || !isset($data->email) || !isset($data->password)) {
    echo json_encode(["success" => false, "message" => "Données incomplètes."]);
    exit;
}

$username = trim($data->username);
$email = trim($data->email);
$password = password_hash($data->password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Violation de contrainte unique
        echo json_encode(["success" => false, "message" => "L'utilisateur ou l'email existe déjà."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur serveur."]);
    }
}
?>
