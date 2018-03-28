<?php
# Datenbankverbindung und DB-Funktionen importieren
require_once("../../includes/db_connection.php");
require_once("../../includes/common.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vokabeltrainer Konjugation Löschen</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    # Hier laden wir Bootstrap und Fontawesome
    require_once("includes/dependencies.php");
    ?>
    <!-- Eigenes Stylesheet -->
    <link rel="stylesheet" type="text/css" href="../../styles.css">
    <!-- Funktionen -->
    <script>
        // Diese Funktion aktualisiert die Vokabelliste, wenn eine Sprache
        // gewählt wird
        function selectLanguage() {
            var val = $("#languagesel").val();
            if(val!="") {
                $("#deleteLanguageButton").attr("disabled",false);
            }
            else {
                $("#deleteLanguageButton").attr("disabled",true);
            }
            if(val!="") {
                $.ajax({
                    type: "POST",
                    url: "ajax/getKonjugationForLanguageId.php",
                    data: {
                        language : val,
                        quantity : 0
                    },
                    cache: false,
                    success: function(answer) {
                        if(answer!="[]") {
                            $("#deleteVocabularyButton").attr("disabled",false);
                            var content="<select class='form-control' id='vocabularysel'>";
                            var phpresponse = JSON.parse(answer);
                            for (x in phpresponse) {
                                content += "<option value='"+phpresponse[x].id+"'>"+phpresponse[x].Deutsch+"</option>";
                            }
                            content += "</select>";
                            $("#vocabularyselcontent").html(content);
                        }
                        else {
                            var content="<select class='form-control' id='vocabularysel'>";
                            content += "<option selected disabled>-------</option>";
                            content += "</select>";
                            $("#vocabularyselcontent").html(content);
                            $("#deleteVocabularyButton").attr("disabled",true);
                            alert("Keine Vokabeln in dieser Sprache vorhanden")
                        }
                    },
                    error: function(){
                        alert("Fehler, kann keinen Anfragedaten senden.");
                    }
                });
            }
        }

        function deleteLanguage() {
            var val = $("#languagesel").val();
            if (window.confirm("Diese Sprache wirklich löschen?") == true) {
                $.ajax({
                    type: "POST",
                    // auch hier einen synchronen aufruf, damit der Seitenreload
                    // erst passiert, wenn die Sprache wirklich gelöscht wurde
                    async: false,
                    url: "ajax/deleteLanguageForId.php",
                    data: { language : val },
                    cache: false,
                    success: function(answer) {
                        alert("Sprache wurde gelöscht")
                    },
                    error: function(answer){
                        alert(answer);
                        alert("Fehler, kann die Sprache grad nicht löschen.");
                    }
                });
                location.reload();
            }
        }

        function deleteVocabulary() {
            var val = $("#vocabularysel").val();
            if (window.confirm("Diese Konjugation wirklich löschen?") == true) {
                $.ajax({
                    type: "POST",
                    // hier auch ein synchroner aufruf
                    async: false,
                    url: "ajax/deleteKonjugationForId.php",
                    data: { konjugationId : val },
                    cache: false,
                    success: function() {
                        alert("Konjugation wurde gelöscht");
                    },
                    error: function(){
                        alert("Fehler, kann die Konjugation grad nicht löschen.");
                    }
                });
                location.reload();
            }
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
            <h2>Sprache oder Vokabel löschen</h2>
            <!-- Select für die Sprachen -->
            <div class="form-group">
                <label for="languagesel">Sprache wählen:</label>
                <select class="form-control" id="languagesel" onchange="selectLanguage()">
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
            <button id="deleteLanguageButton" type="button" class="btn btn-primary" style="width:100%;" onclick="deleteLanguage()" disabled>Sprache Löschen</button>
            <!-- Select für die Vokabeln -->
            <div class="form-group" style="margin-top:25px;">
                <label for="vocabularysel">Vokabel wählen:</label>
                <div id="vocabularyselcontent">
                    <select class="form-control" id="vocabularysel" onchange="activateInputBoxes()" disabled>
                        <option value='0'>-------</option>
                    </select>
                </div>
            </div>
            <button id="deleteVocabularyButton" type="button" class="btn btn-primary" style="width:100%;" onclick="deleteVocabulary()" disabled>Vokabel Löschen</button>
            <a href="vokabeln.php" class="btn btn-primary" style="width:100%;margin-top:25px;">Zurück zur Startseite</a>
        </div>
    </div>
</div>
</body>
</html>