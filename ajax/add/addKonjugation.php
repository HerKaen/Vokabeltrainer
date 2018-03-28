<?php
require_once("../../includes/db_connection.php");
# Statement zum Einfügen einer neuen Vokabel vorbereiten
//$stmt = $pdo->prepare("INSERT INTO Vokabeln (Sprachen_Id,Deutsch,Fremdsprache,Aussprache) VALUES (?,?,?,?)");
$stmt = $pdo->prepare("INSERT INTO Konjugation (Sprachen_Id,Deutsch,Fremdsprache, Zeitform) VALUES (?,?,?,?)");
# Statement ausführen
//$stmt->execute(array($_POST['languageId'],$_POST['deutschWord'],$_POST['fremdspracheWord'],$_POST['ausspracheWord']));
$stmt->execute(array(ucfirst($_POST['languageId']),ucfirst($_POST['deutschWord']),ucfirst($_POST['fremdspracheWord']),ucfirst($_POST['zeitform'])));
?>