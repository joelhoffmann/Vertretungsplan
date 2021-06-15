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
    $EreignisTyp = $_POST["Ereignis_Typ"];
    $Datum = $_POST["Datum"];
    $Klasse = $_POST["Klasse"];
    $Inhalt = $_POST["Inhalt"];
    $anzahl = 0;


    $db = new mysqli('localhost', 'root', '', 'dys');
    if ($db->connect_errno) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }
    mysqli_set_charset($db, "utf8");

    $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(EID) FROM ereignis"))[0] + 1;

    $eintrag = "INSERT INTO ereignis(EID, EreignisTyp, Datum, Klasse, Inhalt) VALUES ('$anzahl', '$EreignisTyp','$Datum','$Klasse','$Inhalt');";

    $eintragen = mysqli_query($db, $eintrag);

    header('location: ../Einstellungen/settings.php');

    mysqli_close($db);

    ?>
</body>

</html>