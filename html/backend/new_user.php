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
    include '../backend/vertretungsplan-anzeigen.php';
    $db = dbConnect();
    $Username = $_POST["Username"];
    $Passwort = $_POST["Passwort"];
    $Email = $_POST["Email"];
    $anzahl = 0;

    $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(UID) FROM benutzer"))[0] + 1;

    $eintrag = "INSERT INTO benutzer(`UID`, `Name`, `Passwort`, `EMail`) VALUES ('$anzahl', '$Username','$Passwort','$Email');";

    $eintragen = mysqli_query($db, $eintrag);

    header('location: ../Einstellungen_new/settings.php');

    mysqli_close($db);

    ?>
</body>
</html>
