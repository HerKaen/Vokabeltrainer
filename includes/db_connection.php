<?php
# Verbindung zur DB
date_default_timezone_set("Europe/Berlin");
# Hier musst du dein Passwort zur DB, welches du bei der Einrichtung von MySQL verwendet hast,
# als letzten Parameter eingeben.

# Online Bplaced
$pdo=new PDO('mysql:host=localhost;dbname=herkaen;charset=utf8;', 'herkaen', 'BananenBrot');

# Localhost Xampp
//$pdo=new PDO('mysql:host=localhost;dbname=vokabeltrainer;charset=utf8;', 'root', '');
?>