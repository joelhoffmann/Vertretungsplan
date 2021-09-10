<?php
//könnte noch zusammengefasst werden
include '../backend/vertretungsplan-anzeigen.php';
$db = dbConnect();

if ($_REQUEST["term2"] == "Geschwindigkeit") {

    if ($_REQUEST["term"]) {
        $uebergang = $_REQUEST["term"];

        if (mysqli_query($db, "SELECT * FROM `settings`")->num_rows) {
            $eintrag = "UPDATE `settings` SET `E2`='$uebergang'";
            $eintragen = mysqli_query($db, $eintrag);
        } else {
            $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM settings"))[0] + 1;
            $eintrag = "INSERT INTO `settings`(`ID`, `E1`, `E2`, `E3`, `E4`, `E5`, `E6`) VALUES ('$anzahl','$uebergang','-','-','-','-','-')";
            $eintragen = mysqli_query($db, $eintrag);
        }

        mysqli_close($db);
        echo "Done";
    } else {
        echo "Zahl eingeben";
    }
} else if ($_REQUEST["term2"] == "Delay") {

    if ($_REQUEST["term"]) {
        $uebergang = $_REQUEST["term"];
        $ip = getenv('REMOTE_ADDR');

        if (mysqli_query($db, "SELECT * FROM `settings`")->num_rows) {
            $eintrag = "UPDATE `settings` SET `E1`='$uebergang'";
            $eintragen = mysqli_query($db, $eintrag);
        } else {
            $anzahl = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(ID) FROM settings"))[0] + 1;
            $eintrag = "INSERT INTO `settings`(`ID`, `E1`, `E2`, `E3`, `E4`, `E5`, `E6`) VALUES ('$anzahl','-','$uebergang','-','-','-','-')";
            $eintragen = mysqli_query($db, $eintrag);
        }

        mysqli_close($db);
        echo "Done";
    } else {
        echo "Zahl eingeben";
    }
}
