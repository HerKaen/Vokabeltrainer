<?php
require_once("../includes/db_connection.php");
# Vokabel aktualisieren
$stmt = $pdo->prepare("UPDATE vokabeln SET Abgefragt=Abgefragt+1, Richtig=(Richtig+:correct) WHERE id=:id");
# Parameter binden
$stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->bindValue(':correct', $_POST['correct'], PDO::PARAM_INT);
$stmt->execute();
?>