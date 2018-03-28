<?php
# Datenbankverbindung und DB-Funktionen importieren
require_once("../../includes/db_connection.php");
require_once("../../includes/common.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vokabeltrainer Neue Sprache</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    # Hier laden wir Bootstrap und Fontawesome
    require_once("../../includes/dependencies.php");
    ?>
    <!-- Eigenes Stylesheet -->
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <!-- Funktionen -->
    <script>
        // Prüfen, ob Box für die neue Sprache nicht leer ist
        function checkBox() {
            var language = $("#language").val();
            if(language!="") {
                // Wenn nicht leer, kann der Button aktiviert werden
                $("#addLanguageButton").attr("disabled",false);
            }
            else {
                $("#addLanguageButton").attr("disabled",true);
            }
        }

        // Hinzufügen einer neuen Sprache
        // Der auslösende Button ist nur aktiv, wenn die
        // zugehörige Input Box nicht leer ist
        function addLanguage() {
            var language = $("#language").val();
            $.ajax({
                type: "POST",
                url: "ajax/addLanguage.php",
                data: {
                    newLanguage : language,
                },
                cache: false,
                success: function(answer) {
                    alert("Die Sprache wurde hinzugefügt");
                    $("#language").val("");
                },
                error: function(){
                    alert("Es ist ein Fehler aufgetreten");
                }
            });
        }
    </script>
</head>
<body style="background-color:#f2f2f2;">
<!-- Bootstrap container, damit der Content bei breiten Bildschirmen nur im
    mittleren Teil dargestellt wird -->
<div class="container">
    <!-- flexbox-container ist eine selbsterstellte Klasse, um den Inhalt
      zu zentrieren -->
    <div class="col-xs-12" id="flexbox-container">
        <div id="language_selectbox">
            <h2>Sprache hinzufügen</h2>
            <div id='newWordsInputContainer'>
                <!-- Inputbox für neue Sprache -->
                <div class="form-group">
                    <label for="deutsch">Neue Sprache:</label>
                    <input type="text" class="form-control" onkeyup="checkBox()" id="language">
                </div>
                <!-- Button für das Hinzufügen der neuen Sprache -->
                <button id="addLanguageButton" type="button" class="btn btn-primary" style="width:100%;" onclick="addLanguage()" disabled>Hinzufügen</button>
                <a href="vokabeln.php" class="btn btn-primary" style="width:100%;margin-top:25px;">Zurück zur Startseite</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>