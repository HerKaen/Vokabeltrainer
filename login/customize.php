<?php
session_start();

require "../includes/navi.html";

require_once("../includes/db_connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daten bearbeiten</title>
</head>
<body>

<link rel="stylesheet" type="text/css" href="../styles.css">

<?php
if (!empty($_SESSION['userid'])){
    ?>

<div class="container">
    <div class="col-xs-12" id="flexbox-container">
        <div id="customizebox">
            <h1>Login</h1><br><br>

            <div class="form-group">

                <form action="?customize=1" method="post">
                    Benutzername:<br>
                    <input type="text" size="40" maxlength="250" name="username"><br><br>

                    Dein Passwort:<br>
                    <input type="password" size="40" maxlength="250" name="passwort"><br>

                    <input type="submit" value="Daten Ändern" class="btn btn-primary" style="width:100%;margin-top:25px;">
                </form>
            </div>

    <?php } ?>

</body>
</html>