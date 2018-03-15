<?php
require_once("../includes/db_connection.php");
# Statement vorbereiten, um eine neue Sprache hinzuzufügen
$stmt = $pdo->prepare("INSERT INTO Sprachen (Sprache) VALUES (?)");
# Statement ausführen
$stmt->execute(array($_POST['newLanguage']));
?>