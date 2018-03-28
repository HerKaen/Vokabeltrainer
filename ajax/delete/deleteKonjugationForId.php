<?php
require_once("../../includes/db_connection.php");
# Statement zum Löschen vorbereiten
$stmt = $pdo->prepare("DELETE FROM Konjugation WHERE id=?;");
# Statement ausführen
$stmt->execute(array($_POST['konjugationId']));
?>