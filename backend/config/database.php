<?php
// Configuration de la base de données
$host = "127.0.0.1";
$dbname = "escape_game";
$username = "root"; // Remplace par ton user MySQL si nécessaire
$password = ""; // Mets ton mot de passe MySQL si nécessaire

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
