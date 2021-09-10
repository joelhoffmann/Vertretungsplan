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
