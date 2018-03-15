<?php
# Datenbankverbindung und DB-Funktionen importieren
require_once("includes/db_connection.php");
require_once("includes/common.php");
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
    <!-- Funktionen -->
    <script>
        function startrun() {
            // Diese Funktion fragt die Sprache und die Anzahl der abzufragenden
            // Vokabeln ab und leitet dann auf die Seite weiter, auf der die
            // Abfragen stattfinden
            var language = $("#languagesel").val();
            var quantity = $("#numbersel").val();
            window.location = "run.php?lan="+language+"&qua="+quantity;
        }

        function selectLanguage() {
            var val = $("#languagesel").val();
            if(val!="") {
                $.ajax({
                    type: "POST",
                    url: "ajax/getCountOfVocabularyForId.php",
                    data: {id : val},
                    cache: false,
                    success: function(answer) {
                        if(answer>0) {
                            $("#infobox").html("<hr><p style='text-align:center;'>"+answer+" Vokablen vorhanden</p><hr>");
                            $("#numbersel").attr("disabled",false);
                            $("#startbutton").attr("disabled",false);
                            <?php
                            # Hier werden die Abstufungen (wie viele Vokabeln abgefragt werden sollen)
                            # ausgegeben
                            $content ="";
                            for ($i=0; $i < sizeof($valid_quantities); $i++) {
                                if($valid_quantities[$i]!='all') {
                                    $content.="if(answer<".$valid_quantities[$i]."){ $(\"#val".($i+1)."\").attr(\"disabled\",true); }";
                                }
                            }
                            echo $content;
                            ?>
                        }
                        else {
                            $("#infobox").html("<hr><p style='text-align:center;color:red;'>Keine Vokablen vorhanden</p><hr>");
                        }
                    },
                    error: function(){
                        alert("Fehler, kann keinen Anfragedaten senden.");
                    }
                });
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
            <h1>Vokabeltrainer</h1>
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
            <div id="infobox"></div>
            <div class="form-group">
                <label for="numbersel">Anzahl Vokabeln wählen:</label>
                <select class="form-control" id="numbersel" disabled>
                    <option value="0">Alle</option>
                    <?php
                    ### Anzahl Vokabeln als Option, werden mit jquery
                    ### deaktiviert
                    $output ="";
                    for ($i=0; $i < sizeof($valid_quantities); $i++) {
                        if($valid_quantities[$i]!="all") {
                            $output.="<option id='val".($i+1)."' value=".$valid_quantities[$i].">".$valid_quantities[$i]."</option>";
                        }
                    }
                    echo $output;
                    ?>
                </select>
            </div>
            <div>
                <button id="startbutton" type="button" class="btn btn-primary" style="width:100%;" onclick="startrun()" disabled>Starten</button>
                <hr>
                <a href="newWord.php" class="btn btn-primary" style="width:100%;margin-top:25px;">Neue Vokabel eingeben</a>
                <a href="newLanguage.php" class="btn btn-primary" style="width:100%;margin-top:25px;">Neue Sprache anlegen</a>
                <a href="delete.php" class="btn btn-warning" style="width:100%;margin-top:25px;">Löschen</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>