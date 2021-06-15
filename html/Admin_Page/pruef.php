<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $login = $_POST["login"];
    $password = $_POST["password"];
    //echo "Hallo $benutzer $pass";

    $db = new mysqli('localhost', 'root', '', 'dys');
    if ($db->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }

    mysqli_set_charset($db, "utf8");

    $erg = $db->query("SELECT * FROM `benutzer` WHERE `Name` LIKE '$login' ");

    if ($erg->num_rows > 0) {
        $zeile = mysqli_fetch_array($erg, MYSQLI_ASSOC);
        if ($zeile['Passwort'] == $password) {
            header('location: ../Einstellungen/settings.php');
        } else {
            echo "Anmeldung fehlgeschlagen";
        }
    } else {
        echo "Benutzer oder Passwort falsch...";
    }


    mysqli_close($db);

    ?>
    <form action="admin_log.php">
        <input type="submit" value="Zurück">
    </form>

</body>

</html>