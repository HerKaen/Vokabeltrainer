<?php
# Verbindung zur DB
date_default_timezone_set("Europe/Berlin");
# Hier musst du dein Passwort zur DB, welches du bei der Einrichtung von MySQL verwendet hast,
# als letzten Parameter eingeben.
$pdo=new PDO('mysql:host=localhost;dbname=herkaen;charset=utf8;', 'root', '');
?>