<?php
# Dieses Array bestimmt die Abstufungen, wie viele
# Vokabeln gefragt werden sollen
$valid_quantities=array(5,15,25,50,0);
# Dies ist eine Funktion zur Überprüfung, dass eine übergebene Quantity
# auch tatsächlich erlaubt ist.
function checkIfValidQuantity($val) {
    global $valid_quantities;
    foreach ($valid_quantities as $quantity) {
        if($quantity==$val) {
            return true;
        }
    }
    return false;
}
# Alle Sprachen abfragen
function getLanguages() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Sprachen");
    $stmt->execute(array());
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>