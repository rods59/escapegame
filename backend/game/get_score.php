<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT users.username, scores.score FROM scores JOIN users ON scores.user_id = users.id ORDER BY score DESC LIMIT 10");
    $scores = $stmt->fetchAll();

    echo json_encode(["success" => true, "scores" => $scores]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur : " . $e->getMessage()]);
}
?>
