<?php
# Datenbankverbindung und DB-Funktionen importieren
require_once("../../includes/db_connection.php");
require_once("../../includes/common.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vokabeltrainer Neue Konjugation</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    # Hier laden wir Bootstrap und Fontawesome
    require_once("../../includes/dependencies.php");
    ?>
    <!-- Eigenes Stylesheet -->
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <!-- Funktionen -->
    <script>
        function activateInputBoxes() {
            // Wenn eine Sprache ausgewählt wurde,
            // werden alle Inputboxen aktiviert
            if($("#languagesel").val()!="") {
                $("#deutsch").attr("disabled",false);
                $("#fremdsprache").attr("disabled",false);
                $("#zeitform").attr("disabled",false);
            }
            else {
                $("#deutsch").attr("disabled",true);
                $("#fremdsprache").attr("disabled",true);
                $("#zeitform").attr("disabled",true);
            }
        }
        // Wenn deutsch,fremdsprache und Zeitform eingetragen
        // sind, wird der Hinzufügen-Button aktiviert
        function checkBoxes() {
            var deutsch = $("#deutsch").val();
            var fremdsprache = $("#fremdsprache").val();
            var zeitform = $("#zeitform").val();
            // var aussprache = $("#aussprache").val();
            if(deutsch!="" && fremdsprache!="" && zeitform!="") {
                $("#addKonjugationButton").attr("disabled",false);
            }
            else {
                $("#addKonjugationButton").attr("disabled",true);
            }
        }

        // Eine neue Konjugation wird hinzugefügt
        function addKonjugation() {
            // Alle Werte aus den Inputboxen abrufen
            var language = $("#languagesel").val();
            var deutsch = $("#deutsch").val();
            var fremdsprache = encodeURIComponent($("#fremdsprache").val());
            var zeitform = $("#zeitform").val();
            // AJAX Aufruf zum Hinzufügen
            $.ajax({
                type: "POST",
                url: "ajax/addKonjugation^.php",
                data: {
                    languageId : language,
                    deutschWord : deutsch,
                    fremdspracheWord : fremdsprache,
                    zeitform : zeitform
                },
                cache: false,
                success: function(answer) {
                    alert("Die Vokable wurde hinzugefügt");
                    // Boxen leeren
                    $("#deutsch").val("");
                    $("#fremdsprache").val("");
                    $("#zeitform").val("");
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
            <h2>Vokabel hinzufügen</h2>
            <div class="form-group">
                <label for="languagesel">Sprache wählen:</label>
                <select class="form-control" id="languagesel" onchange="activateInputBoxes()">
                    <?php
                    ### Alle Sprachen aus der Datenbank holen
                    $languages = getLanguages();
                    $output ="<option selected disabled>-------</option>";
                    ### Alle Sprachen als Option
                    foreach ($languages as $language) {
                        $output.="<option value=".$language['id'].">".$language['Sprache']."</option>";
                    }
                    echo $output;
                    ?>
                </select>
            </div>
            <!-- Hier stehen die Inputboxen -->
            <div id='newWordsInputContainer'>
                <div class="form-group">
                    <label for="deutsch">Deutsch:</label>
                    <input type="text" class="form-control" onkeyup="checkBoxes()" disabled id="deutsch">
                </div>
                <div class="form-group">
                    <label for="fremdsprache">Fremdsprache:</label>
                    <input type="text" class="form-control" onkeyup="checkBoxes()" disabled id="fremdsprache">
                </div>
                <div class="form-group">
                    <label for="zeitform">Zeitform:</label>
                    <input type="text" class="form-control" onkeyup="checkBoxes()" disabled id="zeitform">
                </div>
                <button id="addKonjugationButton" type="button" class="btn btn-primary" style="width:100%;" onclick="addKonjugation()" disabled>Hinzufügen</button>
                <a href="konjugation.php" class="btn btn-primary" style="width:100%;margin-top:25px;">Zurück zur Konjugations-Seite</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>