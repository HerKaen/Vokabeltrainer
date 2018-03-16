<?php
session_start();
session_destroy();

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
                <h2>Ausgeloggt</h2>

                <div class="form-group">

                    <h4>Du wurdest erfolgreich ausgeloggt. <a href="login.php">Zum Login</a></h4>
                </div>
    </body>
    </html>

<?php
/*sleep(3);
header('Location: login.php');*/
?>