<?php
require_once("../../includes/db_connection.php");
# Hier bestimmen wir die Anzahl der Vokabeln für eine Sprache
$stmt = $pdo->prepare("SELECT COUNT(*) FROM Vokabeln WHERE Sprachen_id=:id");
$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->execute();
echo $stmt->fetchColumn();
?>