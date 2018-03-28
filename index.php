<?php

session_start();

require "includes/navi.html";

# Datenbankverbindung und DB-Funktionen importieren
require_once("includes/db_connection.php");
require_once("includes/common.php");

$userid = $_SESSION['userid'];

$stmt = $pdo->prepare("SELECT username FROM user WHERE id=$userid");
$stmt->execute();
$username = $stmt->fetchColumn();

//			echo nl2br(print_r($_SESSION,true));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vokabeltrainer Startseite</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    # Hier laden wir Bootstrap und Fontawesome
    require_once("includes/dependencies.php");
    ?>
    <!-- Eigenes Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body style="background-color:#f2f2f2;">
<div class="container">
    <div class="col-xs-12" id="flexbox-container">
        <div id="language_selectbox">

            <?php if(empty($_SESSION['userid'])) { ?>

            <center><h1>Startseite</h1><br>

                <h4>Dies hier ist ein Vokabeltrainer für jedermann.<br><br>

                    Hier können Sie ganz normal Vokabeln lernen, aber alternativ auch konjugieren üben!<br><br>

                    Viel Spaß damit!
                </h4></center>

            <?php } else { ?>

                <h3>Herzlich willkommen <?php echo "<span style='color:red'>" . $username . "</span>"; ?></h3>

            <?php } ?>

        </div>
    </div>
</div>

</body>
</html>