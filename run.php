<?php
# Datenbankverbindung und DB-Funktionen importieren
require_once("includes/db_connection.php");
require_once("includes/common.php");
# Parameter aus der Adresse
$language=$_GET['lan'];
$quantity=$_GET['qua'];
# Eine zusätzliche Überprüfung, so dass bei GET nicht
# nachträglich eigene Werte eingepfuscht werden können
if(!checkIfValidQuantity($quantity)) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vokabeltrainer</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    require_once("includes/dependencies.php");
    ?>
    <!-- Eigenes Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Funktionen -->
    <script>
        // Ein leeres Array, in dem wir die Vokabelpaare speichern
        var vokabelpaare = new Array();
        // Diese Variable nutzen wir als Zähler
        var currentIndex = 0;
        var correct = 0;

        // Ein Prototyp, mit dem wir ein Vokabelpaar speichern
        // function Vokabelpaar(deutsch, fremdsprache, aussprache, id) {
        function Vokabelpaar(deutsch, fremdsprache, id) {
            this.deutschesWort = deutsch;
            this.fremdspracheWort = fremdsprache;
            this.idWort = id;
        }

        // Hier wird der Inhalt für die Seite erzeugt,
        // wo die Vokabelabfrage stattfindet
        function createVokabelboxContent(index) {
            // HTML Code zusammensetzen
            var content = "<h3>"+vokabelpaare[index].fremdspracheWort+"</h3>";
            content += "<br>";
            content += "<div class='form-group'>";
            content += "<input type='text' class='form-control' style='height:1.5em;font-size:1.5em;padding:5px;' placeholder='Auf deutsch?' id='answerinput'></div>";
            content += "<p>Noch "+(vokabelpaare.length-index)+"</p>";
            content += "<div><button id='nextButton' type='button' class='btn btn-info' onclick='nextVocabulary()'>Prüfen</button>";
            content += "<br><button type='button' style='margin-top:25px;' class='btn btn-danger' onclick='goToStart()'>Schluss</button></div>";
            // HTML Code einsetzen
            $('#vokabelbox').html(content);
        }

        // Benutzer möchte Abfrage abbrechen
        function goToStart() {
            if (window.confirm("Wirklich abbrechen?") == true) {
                window.location = "index.php";
            }
        }

        // Ersten Buchstaben groß machen beim überprüfen
        function ucFirst(string) {
            return string.substring(0, 1).toUpperCase() + string.substring(1);
        }

        // Feedback an DB senden und Modal zeigen
        function nextVocabulary() {
            var userTranslation = ucFirst($('#answerinput').val());
            if(userTranslation==vokabelpaare[currentIndex].deutschesWort) {
                sendFeedback(vokabelpaare[currentIndex].idWort,1);
                correct += 1;
                var correctanswer = "<div style='text-align:center'>";
                correctanswer += "<i class='fa fa-check' style='font-size:10em;color:green;'></i>"
                correctanswer += "</div>";
                $('#modaltitle').html('Richtig!');
                $('#modalbody').html(correctanswer);
                showModal();
            }
            else {
                sendFeedback(vokabelpaare[currentIndex].idWort,0);
                $('#modaltitle').html("Falsch!");
                var correctanswer = "<div style='text-align:center'>";
                correctanswer += "<i class='fa fa-times' style='font-size:10em;color:red;'></i>"
                correctanswer += "<h4>Richtig ist: " + vokabelpaare[currentIndex].deutschesWort + "</h4>";
                correctanswer += "</div>";
                $('#modalbody').html(correctanswer);
                showModal();
            }
        }

        // Feedback senden
        function sendFeedback(idParam,correctParam) {
            $.ajax({
                type: "POST",
                url: "ajax/sendFeedbackToDB.php",
                data: {
                    id : idParam,
                    correct : correctParam
                },
                cache: false
            });
        }

        // Modalfenster zeigen
        function showModal() {
            $('#responseBox').modal('show')
            setTimeout(function() {
                $('#responseBox').modal('hide');
                prepareNextVocabulary();
            }, 2000);
        }

        // Nächste Vokabel laden und Vokabelbox erzeugen
        function prepareNextVocabulary() {
            if(currentIndex<(vokabelpaare.length-1)) {
                currentIndex += 1;
                createVokabelboxContent(currentIndex);
            }
            else {
                // Wenn alle Vokabeln abgefragt wurden, wird die
                // Auswertungsbox gezeigt
                var content = "<h1>Dein Ergebnis</h1>";
                content += "<h3><i class='fa fa-check' style='color:green;margin-right:10px;'></i>Richtige Antworten: "+correct+"</h2>";
                content += "<h3><i class='fa fa-times' style='color:red;margin-right:10px;x'></i>Falsche Antworten: "+(vokabelpaare.length-correct)+"</h2>";
                content += "<a href='index.php' style='margin-top:25px;' class='btn btn-info'>Zurück zur Startseite</button>"
                $('#vokabelbox').html(content);
            }
        }

        // Vokabeln aus Datenbank abrufen
        function getVocabularyFromDB() {
            $.ajax({
                type: "POST",
                // Dies muss ein synchroner Aufruf sein, damit erst weitergemacht
                // wird, wenn die Abfrage vollständig erfolgte
                async: false,
                url: "ajax/getVocabularyForLanguageId.php",
                data: {
                    language : <?php echo $language;?>,
                    quantity : <?php echo $quantity;?>
                },
                cache: false,
                success: function(answer) {
                    var vokpa = new Array();
                    var phpresponse = JSON.parse(answer);
                    for (x in phpresponse) {
                        // vokabelpaare.push(new Vokabelpaar(phpresponse[x].Deutsch,decodeURIComponent(phpresponse[x].Fremdsprache),phpresponse[x].Aussprache,phpresponse[x].id));
                        vokabelpaare.push(new Vokabelpaar(phpresponse[x].Deutsch,decodeURIComponent(phpresponse[x].Fremdsprache),phpresponse[x].id));
                    }
                },
                error: function(){
                    alert("Ein Fehler in der Verbindung");
                }
            });
        }

        // Vokabel besorgen, wenn die Seite fertig geladen wurde
        $( document ).ready(function() {
            getVocabularyFromDB();
            if(vokabelpaare != null && vokabelpaare.length > 0) {
                createVokabelboxContent(currentIndex);
            }
            else {
                alert("Es ist ein Fehler aufgetreten.")
            }
        });

    </script>
</head>
<body style='background-color:#f2f2f2;'>
<div class='container'>
    <div class='col-sm-12' id='flexbox-container'>
        <!-- Hier ist die Vokabelbox -->
        <div id='vokabelbox'></div>
    </div>
</div>

<!-- Das Modal Fenster-->
<div id='responseBox' class='modal fade' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>×</button>
                <h4 class='modal-title' id='modaltitle' style='text-align:center;'></h4>
            </div>
            <div class='modal-body' id='modalbody'></div>
        </div>
    </div>
</div>
</body>
</html>