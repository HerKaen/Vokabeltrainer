<?php
require_once("../../includes/db_connection.php");
# Statement zum Löschen vorbereiten
$stmt = $pdo->prepare("DELETE FROM Vokabeln WHERE Sprachen_id=?;");
# Statement ausführen
$stmt->execute(array($_POST['language']));
# Und nun noch die Sprache löschen
$stmt = $pdo->prepare("DELETE FROM Sprachen WHERE id = ?");
$stmt->execute(array($_POST['language']));
?>