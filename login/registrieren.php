<?php
session_start();

require "../includes/navi.html";

require_once("../includes/db_connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Überprüfe, dass der Benutzername noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username");
        $result = $statement->execute(array('username' => $username));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Dieser Benutzername ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO user (email, passwort, username) VALUES (:email, :passwort, :username)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'username' => $username));

        if($result) {
            echo '<center><h3>Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a></h3></center>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

require_once("../includes/dependencies.php");

if($showFormular) {
    ?>

<link rel="stylesheet" type="text/css" href="../styles.css">

<div class="container">
    <div class="col-xs-12" id="flexbox-container">
        <div id="regbox">
            <h1>Registrierung</h1><br><br>

            <form action="?register=1" method="post">
                Benutzername:<br>
        <input autofocus type="text" size="40" maxlength="250" name="username"><br><br>

                E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Registrierung abschicken" class="btn btn-primary" style="width:100%;margin-top:25px;">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>