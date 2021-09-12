<?php
    include '../backend/vertretungsplan-anzeigen.php';
    $db = dbConnect();

    $Inhalt = $_POST["Nachricht"];
    $Uhrzeit = $_POST["Uhrzeit"];
    $Datum = $_POST["Datum"];
    $anzahl = 0;

    $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(NID) FROM news"))[0] + 1;

    $eintrag = "INSERT INTO `news`(`NID`, `Inhalt`,`Datum`, `Uhrzeit`) VALUES ('$anzahl','$Inhalt','$Datum','$Uhrzeit')";
    $eintragen = mysqli_query($db, $eintrag);

    header('location: ../frontend/settings.php');
    mysqli_close($db);

?>
