<?php
session_start();

require "../includes/navi.html";

require_once("../includes/db_connection.php");

if (isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
//        $_SESSION['uname'] = $user['name'];
//        header('location: ../index.php');
//        header('location: dirname(__DIR__, 1) . /index.php');
        echo '<br><center><h4>Du wurdest erfolgreich eingeloggt. <a href="../index.php">Zum Vokabeltrainer</a></h4></center>';
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<?php
if (isset($errorMessage)) {
    echo $errorMessage;
}

require_once("../includes/dependencies.php");
?>

<link rel="stylesheet" type="text/css" href="../styles.css">

<div class="container">
    <div class="col-xs-12" id="flexbox-container">
        <div id="loginbox">
            <h1>Login</h1><br><br>

            <div class="form-group">

                <form action="?login=1" method="post">
                    E-Mail:<br>
                    <input type="email" size="40" maxlength="250" name="email"><br><br>

                    Dein Passwort:<br>
                    <input type="password" size="40" maxlength="250" name="passwort"><br>

                    <input type="submit" value="Einloggen" class="btn btn-primary" style="width:100%;margin-top:25px;">
                </form>

                <form action="passwortvergessen.php" method="post">
                <input type="submit" value="Passwort vergessen" class="btn btn-danger" style="width:100%;margin-top:25px;">
                </form>
            </div>

</body>
</html>