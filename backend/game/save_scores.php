<?php
require_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['score'])) {
    echo json_encode(["success" => false, "message" => "Données incomplètes."]);
    exit;
}

$user_id = $data['user_id'];
$score = $data['score'];

try {
    $stmt = $pdo->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
    $stmt->execute([$user_id, $score]);

    echo json_encode(["success" => true, "message" => "Score enregistré avec succès."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur : " . $e->getMessage()]);
}
?>
