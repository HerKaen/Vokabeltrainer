<?php
require "../includes/navi.html";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ausgeloggt</title>
</head>
<body>

<?php
require_once("../includes/dependencies.php");
?>

<link rel="stylesheet" type="text/css" href="../styles.css">

<div class="container">
    <div class="col-xs-12" id="flexbox-container">
        <div id="ausgeloggtbox">
            <h1>Ausgeloggt</h1><br><br>

            <div class="form-group">

                <h5>Du hast dich erfolgreich ausgeloggt!</h5>
            </div>

            <?php
            sleep(5);
            header('Location: login.php');
            ?>

</body>
</html>