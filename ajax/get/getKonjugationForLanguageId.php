<?php
require_once("../../includes/db_connection.php");
# Wenn quantity 0 ist, wurde all ausgewählt.
# Hier also kein Limit in der Abfrage
$quantity = $_POST['quantity'];

if ($quantity==0) {
    $stmt = $pdo->prepare("SELECT * FROM Konjugation WHERE Sprachen_id=:id ORDER BY RAND()");
    # Parameter binden
    $stmt->bindValue(':id', $_POST['language'], PDO::PARAM_INT);
}
else {
    # Es gibt ein Limit
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $pdo->prepare("SELECT * FROM Konjugation WHERE Sprachen_id=:id ORDER BY RAND() LIMIT :qua");
    $stmt->bindValue(':id', $_POST['language'], PDO::PARAM_INT);
    $stmt->bindValue(':qua', $quantity, PDO::PARAM_INT);
}
$stmt->execute();
echo ucfirst(json_encode($stmt->fetchAll()));
?>